<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage;

use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\S3ClientInterface;
use Exception;
use Lukasz93P\SymfonyHttpApi\filesStorage\exceptions\FileAddingFailed;
use Lukasz93P\SymfonyHttpApi\filesStorage\exceptions\FileRemovingFailed;
use Lukasz93P\SymfonyHttpApi\filesStorage\exceptions\FileRetrievingFailed;

class S3FilesStorage implements FilesStorage
{
    private const S3_OBJECT_CONTENT_TYPE_KEY = 'ContentType';
    private const S3_OBJECT_BODY_KEY         = 'Body';

    private string $bucketName;

    private S3ClientInterface $s3Client;

    public function __construct(string $bucketName, string $profile, string $region, string $version)
    {
        $this->bucketName = $bucketName;
        $this->s3Client = new S3Client(
            [
                'profile' => $profile,
                'region'  => $region,
                'version' => $version,
            ]
        );
    }

    public function add(FileToStore $fileToStore, string $destinationPath): string
    {
        try {
            (new MultipartUploader(
                $this->s3Client, $fileToStore->getPath(), [
                    'bucket' => $this->bucketName,
                    'key'    => $destinationPath,
                ]
            ))->upload();

            return $destinationPath;
        } catch (Exception $exception) {
            throw FileAddingFailed::fromFilePathAndReason($fileToStore->getPath(), $exception);
        }
    }

    public function get(string $filePath): StoredFile
    {
        try {
            $result = $this->s3Client->getObject(
                [
                    'Bucket' => $this->bucketName,
                    'Key'    => $filePath,
                ]
            );
        } catch (S3Exception $exception) {
            throw FileRetrievingFailed::fromFilePathAndReason($filePath, $exception);
        }

        return StoredFile::fromContentTypeAndBody((string)$result->get(self::S3_OBJECT_CONTENT_TYPE_KEY), (string)$result->get(self::S3_OBJECT_BODY_KEY));
    }

    public function remove(string $filePath): void
    {
        try {
            $this->s3Client->deleteObject(
                [
                    'Bucket' => $this->bucketName,
                    'Key'    => $filePath,
                ]
            );
        } catch (Exception $exception) {
            throw FileRemovingFailed::fromFilePathAndReason($filePath, $exception);
        }
    }

}