<p>Par <em><?php echo $episodes->getAuthor();?></em>, le <?php echo $episodes->getAddDate()->format('d/m/Y à H\hi');?></p>
<h2><?php echo $episodes->getTitle();?></h2>
<p><?php echo (nl2br($episodes->getContent()));?></p>
 
<?php if ($episodes->getAddDate() != $episodes->getModDate()) { ?>
  <p style="text-align: right;"><small><em>Modifiée le <?php echo $episodes->getModDate()->format('d/m/Y à H\hi');?></em></small></p>
<?php } ?>
