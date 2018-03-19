#!/usr/bin/env python
# encoding: utf-8

"""
=================================================
The python version implementation
"Combining Sketch and Tone for Pencil Drawing Production"
Cewu Lu, Li Xu, Jiaya Jia

International Symposium on Non-Photorealistic Animation and Rendering
(NPAR 2012), June, 2012

=================================================
pencil drawing implementation
usage:
    cd {file directory}
    python pencil.py {path of img file you want to try}

"""

from stitch_function import horizontal_stitch as hstitch, vertical_stitch as vstitch
from util import im2double, rot90, rot90c
from natural_histogram_matching import natural_histogram_matching
from PIL import Image
import numpy as np
from scipy import signal
from scipy.ndimage import interpolation
from scipy.sparse import csr_matrix as csr_matrix, spdiags as spdiags
from scipy.sparse.linalg import spsolve as spsolve
import math
import os
import sys
reload(sys)
sys.setdefaultencoding("utf-8")


basedir = os.path.dirname(__file__)
output = os.path.join(basedir, 'output')

line_len_divisor = 40  


Lambda = 0.2
texture_resize_ratio = 0.2
texture_file_name = 'texture.jpg'


def get_s(J, gammaS=1):

    h, w = J.shape
    line_len_double = float(min(h, w)) / line_len_divisor

    line_len = int(line_len_double)
    line_len += line_len % 2

    half_line_len = line_len / 2

   
    # compute the image gradient 'Imag'
    dJ = im2double(J)
    Ix = np.column_stack((abs(dJ[:, 0:-1] - dJ[:, 1:]), np.zeros((h, 1))))
    Iy = np.row_stack((abs(dJ[0:-1, :] - dJ[1:, :]), np.zeros((1, w))))
    # eq.1
    Imag = np.sqrt(Ix*Ix + Iy*Iy)


    # Image.fromarray((1 - Imag) * 255).show()

    # create the 8 directional line segments L
   
    
    L = np.zeros((line_len, line_len, 8))
    for n in range(8):
        if n == 0 or n == 1 or n == 2 or n == 7:
            for x in range(0, line_len):
                y = round(((x+1) - half_line_len) * math.tan(math.pi/8*n))
                y = half_line_len - y
                if 0 < y <= line_len:
                    L[int(y-1), x, n] = 1
                if n < 7:
                    L[:, :, n+4] = rot90c(L[:, :, n])
    L[:, :, 3] = rot90(L[:, :, 7])

    G = np.zeros((J.shape[0], J.shape[1], 8))
    for n in range(8):
        G[:, :, n] = signal.convolve2d(Imag, L[:, :, n], "same")    # eq.2

    Gindex = G.argmax(axis=2)  
    # C is map set
    C = np.zeros((J.shape[0], J.shape[1], 8))
    for n in range(8):
      
        C[:, :, n] = Imag * (1 * (Gindex == n))

    # line shaping
    # generate lines at each pixel
    Spn = np.zeros((J.shape[0], J.shape[1], 8))
    for n in range(8):
        Spn[:, :, n] = signal.convolve2d(C[:, :, n], L[:, :, n], "same")

   
    Sp = Spn.sum(axis=2)
    Sp = (Sp - Sp[:].min()) / (Sp[:].max() - Sp[:].min())
    S = (1 - Sp) ** gammaS

    img = Image.fromarray(S * 255)
    # img.show()

    return S


def get_t(J, type, gammaI=1):
   

    Jadjusted = natural_histogram_matching(J, type=type) ** gammaI
    # Jadjusted = natural_histogram_matching(J, type=type)

    texture = Image.open(texture_file_name)
    texture = np.array(texture.convert("L"))
    # texture = np.array(texture)
    texture = texture[99: texture.shape[0]-100, 99: texture.shape[1]-100]

    ratio = texture_resize_ratio * min(J.shape[0], J.shape[1]) / float(1024)
    texture_resize = interpolation.zoom(texture, (ratio, ratio))
    texture = im2double(texture_resize)
    htexture = hstitch(texture, J.shape[1])
    Jtexture = vstitch(htexture, J.shape[0])

    size = J.shape[0] * J.shape[1]

    nzmax = 2 * (size-1)
    i = np.zeros((nzmax, 1))
    j = np.zeros((nzmax, 1))
    s = np.zeros((nzmax, 1))
    for m in range(1, nzmax+1):
        i[m-1] = int(math.ceil((m+0.1) / 2)) - 1
        j[m-1] = int(math.ceil((m-0.1) / 2)) - 1
        s[m-1] = -2 * (m % 2) + 1
    dx = csr_matrix((s.T[0], (i.T[0], j.T[0])), shape=(size, size))

    nzmax = 2 * (size - J.shape[1])
    i = np.zeros((nzmax, 1))
    j = np.zeros((nzmax, 1))
    s = np.zeros((nzmax, 1))
    for m in range(1, nzmax+1):
        i[m-1, :] = int(math.ceil((m-1+0.1)/2) + J.shape[1] * (m % 2)) - 1
        j[m-1, :] = math.ceil((m-0.1)/2) - 1
        s[m-1, :] = -2 * (m % 2) + 1
    dy = csr_matrix((s.T[0], (i.T[0], j.T[0])), shape=(size, size))

    
    Jtexture1d = np.log(np.reshape(Jtexture.T, (1, Jtexture.size), order="f") + 0.01)
    Jtsparse = spdiags(Jtexture1d, 0, size, size)
    Jadjusted1d = np.log(np.reshape(Jadjusted.T, (1, Jadjusted.size), order="f").T + 0.01)

    nat = Jtsparse.T.dot(Jadjusted1d)   # lnJ(x)
    a = np.dot(Jtsparse.T, Jtsparse)
    b = dx.T.dot(dx)
    c = dy.T.dot(dy)
    mat = a + Lambda * (b + c)     # lnH(x)

    # x = spsolve(a,b) <--> a*x = b
    # lnH(x) * beta(x) = lnJ(x) --> beta(x) = spsolve(lnH(x), lnJ(x))
   
    beta1d = spsolve(mat, nat)  # eq.8
    beta = np.reshape(beta1d, (J.shape[0], J.shape[1]), order="c")

   
    T = Jtexture ** beta    # eq.9
    T = (T - T.min()) / (T.max() - T.min())

    img = Image.fromarray(T * 255)
    # img.show()

    return T


def pencil_draw(path="img/sjtu.jpg", gammaS=1, gammaI=1):
    name = path.rsplit("/")[-1].split(".")[0]
    suffix = path.rsplit("/")[-1].split(".")[1]

    imr = Image.open(path)
    type = "colour" if imr.mode == "RGB" else "black"
    im = imr.convert("L")
    J = np.array(im)
    S = get_s(J, gammaS=gammaS)
    T = get_t(J, type, gammaI=gammaI)
    IPencil = S * T
    img = Image.fromarray(IPencil * 255)
    # img.show()

    save_output(Image.fromarray(S * 255), name + "_s", suffix)
    save_output(Image.fromarray(T * 255), name + "_t", suffix)
    save_output(img, name + "_pencil", suffix)

    return name + suffix


def make_output_dir():
    if not os.path.exists(output):
        os.mkdir(output)


def save_output(img, name, suffix):
    if img.mode != 'RGB':
        img = img.convert('RGB')
    make_output_dir()
    name = os.path.join(output, name)
    filename = "{0}.{1}".format(name, suffix)
    img.save(filename)


if __name__ == "__main__":
    args = sys.argv
    length = len(args)
    if length > 1:
        path = args[1]
        pencil_draw(path=path)
    else:
        pencil_draw()
