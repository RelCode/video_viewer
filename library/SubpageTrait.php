<?php
namespace Library;
trait getUserPref//user preferences refers to which page this becomes (liked::viewed) videos
{
    public function currentSubpage()
    {
        $this->subpage = isset($_GET['subpage']) ? $_GET['subpage'] : 'viewed';
        if ($this->subpage != 'viewed' && $this->subpage !== 'liked') {
            $this->subpage = 'viewed';
        }
        return $this->subpage;
    }
}