<?php 
    use yii\helpers\Url;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <?php if (!Yii::$app->user->isGuest) { ?>
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::base().'/img/user.jpg' ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->name ?></p>

                <a href="#"><i class="circle text-success"></i> <?= Yii::$app->user->identity->email ?></a>
            </div>
        </div>
        <?php } ?>

        <?php if (!Yii::$app->user->isGuest) { ?>
        <?php   
            $menuItems = [
                ['label' => '<b>MENU</b>', 'encode' => false, 'options' => ['class' => 'header']],

                ['label' => 'Beranda', 'icon' => 'dashboard', 'url' => ['/site/index']],
                ['label' => 'UKW Draft', 'icon' => 'file-o', 'url' => ['/exam-draft/index']],
                ['label' => 'UKW Diajukan', 'icon' => 'file-o', 'url' => ['/exam-submitted/index']],
                ['label' => 'UKW Diperiksa', 'icon' => 'file-o', 'url' => ['/exam-checked/index']],
                ['label' => 'UKW Disetujui', 'icon' => 'file-o', 'url' => ['/exam-approved/index']],
                ['label' => 'UKW Ditolak', 'icon' => 'file-o', 'url' => ['/exam-rejected/index']],
                ['label' => 'UKW Selesai', 'icon' => 'file-o', 'url' => ['/exam-done/index']],
                ['label' => 'Laporan', 'icon' => 'files-o', 'url' => ['/exam-report/index']],
                ['label' => 'Verifikasi Sertifikat', 'icon' => 'search', 'url' => ['/site/verify-certificate']],
            ];

            // $menuItems = mdm\admin\components\Helper::filter($menuItems);
        ?>
        <?php } else { ?>
            <?php 
            $menuItems = [
                ['label' => '<b>MENU</b>', 'encode' => false, 'options' => ['class' => 'header']],
                ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ['label' => 'Lupa Password', 'url' => ['site/request-password-reset'], 'visible' => Yii::$app->user->isGuest],
            ];
            ?>
        <?php } ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menuItems,
            ]
        ) ?>
        
        <!-- <ul class="sidebar-menu"><li><a href="<?= \yii\helpers\Url::to(['site/logout']) ?>" data-method="post"><i class="sign-out"></i>  <span>Logout</span></a></li></ul> -->
    
    </section>

</aside>
