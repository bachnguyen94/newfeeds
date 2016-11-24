<?php

/**
 * All functions that not related to cakephp should be here
 */
class Core 
{
    /**
     * Generage a random code with timespan
     * @return random code
     */
    public static function randomCode()
    {
        return mt_rand(1111111111, 9999999999) . time() . mt_rand(1111111111, 9999999999);
    }

    /**
     * Move the uploaded file from tmp directory to real directory
     * @throws Exception
     * @param string $file : the $_File upload
     * @param string $model : the model of table
     * @param string $path : the destination path
     * @return void
     */
    public static function uploadFile($file, $model, $path = null)
    {
        $folderUpload = $model;
        $modelExplode = explode('.', $model);
        if (isset($modelExplode[1])) {
            $folderUpload = $modelExplode[1];
        }

        if (!$path) {
            $path = PATH_IMAGE_FILE;
        }
        $path .= $folderUpload.DS;
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = time().rand(0, 1000).'.'.$extension;

        if (PHPUNIT_RUNNING) {//run command phpunit test
            if (copy(WWW_ROOT.'tmpfiletest'.DS.'tmp_file', $path.$newName)) {
                unlink($path.$newName);
                return $newName;
            };
            return null;
        }

        if (@move_uploaded_file($file['tmp_name'], $path.$newName))
        {
            return $newName;
        };
        return null;
    }
    
    /**
     * Convert string to slug
     * @throws Exception
     * @param string $string : string to convert
     * @return slug
     */
    public static function toSlug($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    /**
     * Check the string is url or not
     * @throws Exception
     * @param string $url : url to check
     * @return bool
     */
    public static function isURL($url)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }

    /**
     * Delete all files in folder
     * @param string $dirPath : path of folder to delete
     * @return void
     */
    public static function deleteFolder($dirPath) {

        if (! is_dir($dirPath)) {
            return;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteFolder($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}

?>