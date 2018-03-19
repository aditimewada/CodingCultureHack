#!/usr/bin/env python
# encoding: utf-8

import numpy as np
import math


def heaviside(x):
    return x if x >= 0 else 0


def p1(x):
    
    return float(1) / 9 * math.exp(-(256 - x) / float(9)) * heaviside(256 - x)


def p2(x):
   
    return float(1) / (225 - 105) * (heaviside(x - 105) - heaviside(x - 225))


def p3(x):
   
    return float(1) / math.sqrt(2 * math.pi * 11) * \
           math.exp(-((x - 90) ** 2) / float(2*(11 ** 2)))


def p(x, type="black"):
   
    if type == "colour":
        return 62*p1(x) + 30*p2(x) + 5*p3(x)
    else:
        return 76*p1(x) + 22*p2(x) + 2*p3(x)


def natural_histogram_matching(I, type="black"):
   

  
    # Prepare the histogram of image 'I', which is 'ho'
    ho = np.zeros((1, 256))
    po = np.zeros((1, 256))
    for i in range(256):
        po[0, i] = sum(sum(1 * (I == i)))     # d
    po /= float(sum(sum(po)))
    ho[0, 0] = po[0, 0]
    for i in range(1, 256):
        ho[0, i] = ho[0, i-1] + po[0, i]

  
    # Prepare the 'natural' histogram which is 'histo'
    histo = np.zeros((1, 256))
    prob = np.zeros((1, 256))
    for i in range(256):
        # prob[0, i] = p(i+1) # eq.4
        prob[0, i] = p(i, type) # eq.4
    prob /= float(sum(sum(prob)))
    histo[0] = prob[0]
    for i in range(1, 256):
        histo[0, i] = histo[0, i-1] + prob[0, i]


    # Do the histogram matching
    Iadjusted = np.zeros((I.shape[0], I.shape[1]))
    for x in range(I.shape[0]):
        for y in range((I.shape[1])):
            histogram_value = ho[0, I[x, y]]
            index = (abs(histo - histogram_value)).argmin()
            Iadjusted[x, y] = index
    Iadjusted /= float(255)
    return Iadjusted


def main():
    from PIL import Image
    imr = Image.open("/Users/lizheming/Project/Python/Pencil/sign.png")
    im = imr.convert("L")
    J = np.array(im)
    natural_histogram_matching(J)


if __name__ == "__main__":
    main()
