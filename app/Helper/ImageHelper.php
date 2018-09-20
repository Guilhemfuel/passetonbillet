<?php


namespace App\Helper;

use App\Ticket;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class ImageHelper
{

    /**
     * Get the image as a string, fit it to the desired size and compress it in jpeg, upload it to S3.
     *
     * @param $fitSize
     * @param $image
     * @param $destinationPath : filename to use to save the image on S3
     *
     * @return string: path of the uploaded file
     */
    public function fitImageAndUploadToS3( $fitSize, $image, $destinationPath )
    {
        $image = Image::make($image)->fit($fitSize);

        return $this->savePictureToS3( $image->stream('jpg'), $destinationPath );
    }

    /**
     * Get the image as a string, resize it and compress it in jpeg, upload it to S3.
     *
     * @param $width
     * @param $height
     * @param $aspectRatio
     * @param $imageString
     * @param $destinationPath : filename to use to save the image on S3
     *
     * @return string: path of the uploaded file
     */
    public function resizeImageAndUploadToS3( $width, $height, $aspectRatio, $image, $destinationPath, $filename = null )
    {

        $image = Image::make($image);

        if ($width && $height) {
            $image->resize($width, $height);
        } elseif ($width && !$height) {
            if($aspectRatio){
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image->resize($width, null);

            }
        } else {
            if($aspectRatio){
                $image->resize($height, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image->resize($height, null);

            }
        }

        return $this->savePictureToS3( $image->stream('jpg'), $destinationPath, $filename );
    }


    /**
     * Convert the image: store it using the filesystem, then save the path to database. If we're not passed an image,
     * do nothing and return the value.
     *
     * @param $imageString : the string value of the image
     * @param $destinationPath : the directory path where to store the image on S3
     *
     * @return string: the path to the uploaded file
     */
    private function savePictureToS3( $imageString, $destinationPath, $filename = null )
    {
        $disk = 's3';

        // 0. Make the image
        $image = Image::make( $imageString );
        // 1. Generate a filename if needed.
        if (!$filename) {
            $filename = md5( $imageString . time() . rand( 0, 100 ) ) . '.jpg';
        }
        // 2. Store the image on disk.
        \Storage::disk( $disk )->put( $destinationPath . '/' . $filename, (string) $image->stream() );

        // 3. Save the path to the database
        return $this->getS3Url( $destinationPath . '/' . $filename );
    }

    /**
     * Builds the url to a file uploaded on S3.
     *
     * @param $path
     *
     * @return string
     */
    public function getS3Url( $path )
    {
        $region = \Config::get( 'filesystems.disks.s3.region' );
        $bucket = \Config::get( 'filesystems.disks.s3.bucket' );

        return \Storage::disk( 's3' )->url( $path );
    }

    /**
     * Returns an image for a given ticket
     *
     * @param Ticket $ticket
     */
    public function ticketPreview(Ticket $ticket) {

        $img = \Image::make(file_get_contents(resource_path('assets/img/empty-ticket.png')));

        // Write day
        $img->text($ticket->train->departure_date->format('d'),600,160,function($font) {
            $font->file(resource_path('assets/fonts/DINCondensed-Bold.ttf'));
            $font->size(90);
            $font->color('#FF9601');
            $font->align('center');
        });

        // Write Month
        $img->text($ticket->train->departure_date->format('F'),600,270,function($font) {
            $font->file(resource_path('assets/fonts/DINCondensed-Bold.ttf'));
            $font->size(60);
            $font->color('#FFFFFF');
            $font->align('center');
        });

        // Write seller
        $img->text(__('tickets.component.sold_by_sm').' '.$ticket->user->full_name,1000,110,function($font) {
            $font->file(resource_path('assets/fonts/DINCondensed-Bold.ttf'));
            $font->size(40);
            $font->color('#FFFFFF');
            $font->align('center');
        });

        // Write Stations
        $img->text($ticket->train->departureCity->name,236,370,function($font) {
            $font->file(resource_path('assets/fonts/DINCondensed-Bold.ttf'));
            $font->size(45);
            $font->color('#FFFFFF');
            $font->align('center');
        });
        $img->text($ticket->train->arrivalCity->name,956,370,function($font) {
            $font->file(resource_path('assets/fonts/DINCondensed-Bold.ttf'));
            $font->size(45);
            $font->color('#FFFFFF');
            $font->align('center');
        });

        // Write times
        $img->text(substr($ticket->train->departure_time,0,5),236,410,function($font) {
            $font->file(resource_path('assets/fonts/DINCondensed-Bold.ttf'));
            $font->size(35);
            $font->color('#FFFFFF');
            $font->align('center');
        });
        $img->text(substr($ticket->train->arrival_time,0,5),956,410,function($font) {
            $font->file(resource_path('assets/fonts/DINCondensed-Bold.ttf'));
            $font->size(35);
            $font->color('#FFFFFF');
            $font->align('center');
        });

        // And price
        $img->text($ticket->full_price,600,570,function($font) {
            $font->file(resource_path('assets/fonts/DINCondensed-Bold.ttf'));
            $font->size(80);
            $font->color('#5D5C5D');
            $font->align('center');
        });

        return $img;

    }

}