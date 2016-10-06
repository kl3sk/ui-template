<?php

namespace Kl3sk\Controller\Tool;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;


class DirController
{
    private $dir;
    private $markup;
    private $arrayDir = array();
    private $return;
    
    public function __construct($dir, $markup = array('<ul>', '</ul>', '<li>', '</li>'))
    {
        $this->dir = $dir;
        $this->markup = $markup;
        $this->return = '';
    }
    
    private function createArray()
    {
        $ritit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->dir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($ritit as $splFileInfo) {
            $path = $splFileInfo->isDir()
             ? array($splFileInfo->getFilename() => array())
             : array($splFileInfo->getFilename());
            
            for ($depth = $ritit->getDepth() - 1; $depth >= 0; $depth--) {
                $path = array($ritit->getSubIterator($depth)->current()->getFilename() => $path);
            }
            $this->arrayDir = array_merge_recursive($this->arrayDir, $path);
        }
        
        return $this->arrayDir;
    }
    
    private function createMenu($dir)
    {
        
        foreach ($this->arrayDir as $folder => $file) {
            $this->return .= $folder;
            $this->return .= $this->markup[0];
            if (is_array($file)) {
                $this->return .= $this->markup[2].$folder.$this->markup[3];
                $this->createMenu($dir);
            } else {
                $this->return .= $this->markup[2].$file.$this->markup[3];
            }
            $this->return .= $this->markup[1];
        }
    }
    
    public function menuAction()
    {
        ToolController::d($this->createArray());

//        return $this->markup[0] . $this->createMenu($this->dir) . $this->markup[1];
    }
}
