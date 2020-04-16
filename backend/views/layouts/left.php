<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => [
                        ['label' => 'Menú', 'options' => ['class' => 'header']],
                        ['label' => 'Aplicación', 'icon' => 'home', 'url' => ['../../../frontend/web']],
                        ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                        [
                            'label' => 'Parametrización',
                            'icon' => 'cogs',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Roles y permisos', 'icon' => 'lock', 'url' => ['/auth-item'],],
                                ['label' => 'Jerarquía de permisos', 'icon' => 'sitemap', 'url' => ['/auth-item-child'],],
                            ],
                        ],
                        [
                            'label' => 'Utilidades',
                            'icon' => 'bolt',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Permisos VS Usuarios', 'icon' => 'address-card', 'url' => ['/auth-assignment'],],
                            ],
                        ],
                    ],
                ]
        )
        ?>

    </section>

</aside>
