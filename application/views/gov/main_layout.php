<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('gov/includes/header'); ?>
<script src="<?php echo site_url('common_libs/js/jquery.min.js');?>"></script>
<?php $this->load->view('gov/includes/menusidebar'); ?>
<?php $this->load->view('gov/components/'.$subview); ?>
<?php $this->load->view('gov/includes/footer'); ?>