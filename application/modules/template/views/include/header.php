<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Adicom<?=isset($site_title)?' - '.$site_title:''?></title>

    <?php if(isset($css_main))foreach($css_main as $row) echo $row;?>
    <?php if(isset($css)) foreach($css as $row) echo $row;?>

    <?php if(isset($js_main)) foreach($js_main as $row) echo $row;?>
    <?php if(isset($js)) foreach($js as $row) echo $row;?>
     
    <link rel="icon" href="<?=base_url()?>/favicon.ico">   
</head>

<body>
<div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="pleaseWaitDialogLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pleaseWaitDialogLabel">Przesyłanie danych, proszę czekać...</h5>
<div class="progress">
  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
  </div>
</div>
      </div>
    </div>
  </div>
</div>

<?php if ($this->session->flashdata('error') != ''):?>
  <div class="bb-alert alert alert-danger"><span><?=$this->session->flashdata('error');?></span></div>
<?php endif;?>

<div class="bb-alert alert alert-info" style="display:none;"><span>Alerty</span></div>

       
