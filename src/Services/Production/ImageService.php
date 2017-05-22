<?php
namespace LaravelRocket\Foundation\Services\Production;

use LaravelRocket\Foundation\Services\ImageServiceInterface;

class ImageService extends BaseService implements ImageServiceInterface
{
    public function convert($src, $dst, $format, $size, $needExactSize = false, $backgroundColor='#FFFFFF')
    {
        $image = new \Imagick($src);
        $image = $this->fixImageOrientation($image);
        $image = $this->setImageSize($image, $size, $needExactSize);
        if (!empty($format)) {
            $image = $this->setImageFormat($image, $format, $backgroundColor);
        }
        $image->writeImage($dst);

        return [
            'height' => $image->getImageHeight(),
            'width'  => $image->getImageWidth(),
        ];
    }

    /**
     * @ref http://www.b-prep.com/blog/?p=1764
     *
     * @param \Imagick $image
     *
     * @return \Imagick
     */
    private function fixImageOrientation($image)
    {
        $orientation = $image->getImageOrientation();
        switch ($orientation) {
            case \Imagick::ORIENTATION_UNDEFINED:
                break;
            case \Imagick::ORIENTATION_TOPLEFT:
                break;
            case \Imagick::ORIENTATION_TOPRIGHT:
                $image->flopImage();
                $image->setimageorientation(\Imagick::ORIENTATION_TOPLEFT);
                break;
            case \Imagick::ORIENTATION_BOTTOMRIGHT:
                $image->rotateImage(new \ImagickPixel(), 180);
                $image->setimageorientation(\Imagick::ORIENTATION_TOPLEFT);
                break;
            case \Imagick::ORIENTATION_BOTTOMLEFT:
                $image->rotateImage(new \ImagickPixel(), 180);
                $image->flopImage();
                $image->setimageorientation(\Imagick::ORIENTATION_TOPLEFT);
                break;
            case \Imagick::ORIENTATION_LEFTTOP:
                $image->rotateImage(new \ImagickPixel(), 90);
                $image->flopImage();
                $image->setimageorientation(\Imagick::ORIENTATION_TOPLEFT);
                break;
            case \Imagick::ORIENTATION_RIGHTTOP:
                $image->rotateImage(new \ImagickPixel(), 90);
                $image->setimageorientation(\Imagick::ORIENTATION_TOPLEFT);
                break;
            case \Imagick::ORIENTATION_RIGHTBOTTOM:
                $image->rotateImage(new \ImagickPixel(), 270);
                $image->flopImage();
                $image->setimageorientation(\Imagick::ORIENTATION_TOPLEFT);
                break;
            case \Imagick::ORIENTATION_LEFTBOTTOM:
                $image->rotateImage(new \ImagickPixel(), 270);
                $image->setimageorientation(\Imagick::ORIENTATION_TOPLEFT);
                break;
        }

        return $image;
    }

    /**
     * @param \Imagick $image
     * @param array    $size
     * @param bool     $needExactSize
     *
     * @return \Imagick
     */
    private function setImageSize($image, $size, $needExactSize = false)
    {
        if (empty($size)) {
            return $image;
        }

        if ($needExactSize || $image->getImageWidth() > $size[0]) {
            if( $size[0] == 0 || $size[1] == 0 ) {
                $image->scaleImage($size[0], $size[1]);
            }else {
                $image->cropThumbnailImage($size[0], $size[1]);
            }
        }

        return $image;
    }

    /**
     * @param \Imagick $image
     * @param string   $format
     * @param string   $backgroundColor
     *
     * @return \Imagick
     */
    private function setImageFormat($image, $format, $backgroundColor='#FFFFFF')
    {
        if ($image->getImageFormat() !== $format) {
            if ($format == 'jpg' || $format == 'jpeg') {
                $image->setImageBackgroundColor(new \ImagickPixel($backgroundColor));
                $image = $image->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
            }

            $image->setImageFormat($format);
        }
        if ($format == 'jpeg') {
            $image->setImageCompressionQuality(90);
        }

        return $image;
    }
}
