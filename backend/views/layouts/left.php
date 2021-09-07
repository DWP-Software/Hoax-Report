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

                <a href="#"><i class="circle text-success"></i> <?= Yii::$app->user->identity->roles ?></a>
            </div>
        </div>
        <?php } ?>

        <?php if (!Yii::$app->user->isGuest) { ?>
        <?php   
            $menuItems = [
                ['label' => '<b>MENU</b>', 'encode' => false, 'options' => ['class' => 'header']],

                ['label' => 'Laporan', 'icon' => 'dashboard', 'url' => ['/site/index']],
                ['label' => 'Berita', 'icon' => 'newspaper-o ', 'url' => ['/news/index']],
                ['label' => 'Kategori', 'icon' => 'list', 'url' => ['/category/index']],
                ['label' => 'Kelola User', 'icon' => 'users', 'url' => ['/user/index']],
                [
                    'label' => 'Access Control',
                    'icon' => 'lock',
                    'url' => '#',
                    'options' => ['class' => 'treeview'],
                    'visible' => Yii::$app->user->can('superuser'),
                    'items' => [
                        ['label' => 'User',         'url' => ['/user/index']],
                        ['label' => 'Assignment',   'url' => ['/acf/assignment']],
                        ['label' => 'Role',         'url' => ['/acf/role']],
                        ['label' => 'Permission',   'url' => ['/acf/permission']],
                        ['label' => 'Route',        'url' => ['/acf/route']],
                        ['label' => 'Rule',         'url' => ['/acf/rule']],
                    ],
                ],
                ['label' => 'User', 'icon' => 'user', 'url' => ['/user/index'],'visible' => Yii::$app->user->can('superuser')],
                ['label' => 'Log', 'icon' => 'clock-o', 'url' => ['/log/index'],'visible' => Yii::$app->user->can('superuser')],
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

