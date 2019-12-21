<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage;


class Factory
{
    public static function localStorage(string $dataDestinationDirectory): FilesStorage
    {
        return new LocalFilesStorage($dataDestinationDirectory);
    }

    public static function s3(): FilesStorage
    {
        return new S3FilesStorage(getenv('S3_BUCKET_NAME'), getenv('S3_PROFILE'), getenv('S3_REGION'), getenv('S3_VERSION'));
    }

}