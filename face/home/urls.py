from django.conf.urls import url
from django.conf import settings
from . import views
from django.conf.urls.static import static
app_name = 'main'
urlpatterns = [
    url(r'^$',views.home,name="home"),
    url(r'^user/save_image/$',views.save_image,name="save_image"),
 ]
if settings.DEBUG is True:
    urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)