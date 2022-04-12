<?= view("UI/head"); ?>
<?= view("UI/sidebar"); ?>


<div class="content-wrapper">
  <section class="content-header border-bottom">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1><?= (isset($title) ? $title : '') ?></h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content mt-3">
    <div class="container-fluid">
      <?= view($view); ?>
    </div><!-- /.container-fluid -->
  </section>
</div>

<?= view("UI/scripts"); ?>