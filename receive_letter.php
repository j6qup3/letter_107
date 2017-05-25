<?php include_once("inc/header.php");?>
<?php include_once("inc/navi.php"); ?>
<?php include_once("inc/sidebar.php"); ?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <? include ("inc/page-header.php"); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">掛號信件領取</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <table class="dt-Table table table-hover table-striped table-bordered" id="oTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>姓名</th>
                                                <th>信件號碼</th>
                                                <th>收件日期</th>
                                                <th>領取日期</th>
                                                <th>代領人</th>
                                                <th>備註</th>
                                                <th>校區</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- /.container-fluid -->
</div>

<?php include_once("inc/footer.php");?>