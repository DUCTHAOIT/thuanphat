<?php
class fileSystem
{
    /**
     * Method Download File Content
     * @param File Content, File Name, File Type, Extension
     */
    public function downloadFile($FileString, $FileName, $FileType, $Ext)
    {
        header('Content-Type: ' . $FileType);
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Disposition: attachment; filename="' . $FileName . "." . $Ext . '"');
        header('Content-Length: ' . strlen($FileString));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        
        echo $FileString;
        exit;
    }
    
    /**
     * Method Get File Content
     * @param str
     * @return str
     */
    public function getContent($File)
    {
        return file_get_contents($File);
    }
    
    /**
     * Method Write File Content
     * @param File path, Write Type, Content
     */
    public function writeFile($File, $Type, $Content)
    {
        $Handle = @fopen($File,$Type);
        fwrite($Handle, $Content);
        @fclose($Handle);
    }
    
    /**
     * Method Read and Show Folder Item
     * @param Folder path
     * @return array
     */
    public function showDir($Folder)
    {
        $ItemArray = array();
        if (is_dir($Folder))
        {
            if ($Handle = @opendir($Folder))
            {
                while (($Item = readdir($Handle)) !== false)
                {
                    $ItemArray[] = $Item;
                }
                @closedir($Handle);
            }
        }
        
        return $ItemArray;
    }
    
    /**
     * Method Delete File
     * @param File path
     */
    public function delFile($File)
    {
        @unlink($File);
    }
    
    /**
     * Method Creat Folder
     * @param Folder path
     */
    public function creatFolder($Folder,$chmod=0775)
    {
        @mkdir($Folder,$chmod);
    }
    
    /**
     * Method Remove Dir
     * @param Folder path
     */
    public function removeDir($Dir)
    {
        $ItemArray = $this->showDir($Dir);
        for ($i=0; $i<sizeof($ItemArray); $i++)
        {
            if ($ItemArray[$i] != "." && $ItemArray[$i] != "..")
             {
                   if (is_dir($Dir."/".$ItemArray[$i]))
                   {
                     $this->removeDir($Dir."/".$ItemArray[$i]);
                   }
                   else
                   {
                     $this->delFile($Dir."/".$ItemArray[$i]);
                   }
             }
        }
        
           @rmdir($Dir);
    }
} 

?>