<?php

class CKSitemap extends Controller {

    function CKSitemap()
    {
        parent::Controller();
    }

    function index()
    {
    	$this->load->library('sitemap');
        // Show the index page of each controller (default is FALSE)
        $this->sitemap->set_option('show_index', true);

        // Exclude all methods from the "Test","Job" & "Sitemap" controller
        $this->sitemap->ignore('Test', '*');
        $this->sitemap->ignore('Job', '*');
        $this->sitemap->ignore('CKSitemap', '*');

        // Exclude a list of methods from any controller
        $this->sitemap->ignore('*', array('view', 'create', 'edit', 'delete'));

        // Show the sitemap
        echo $this->sitemap->generate();
    }
}

/* End of file cksitemap.php */
/* Location: ./system/application/controllers/cksitemap.php */