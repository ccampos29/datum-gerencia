<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <span class="fa fa-user-circle-o" style="color:#fff;font-size: 40px;"></span>
            </div>
            <div class="pull-left info">
                <p><?php

                    use yii\helpers\Url;

                    echo Yii::$app->user->identity->name
                    ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?=
            dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => [
                        ['label' => 'Menú', 'options' => ['class' => 'header']],
                        ['label' => 'Inicio', 'icon' => 'home', 'url' => ['/']],
                        ['label' => 'Usuarios', 'icon' => 'users', 'url' => ['/user']],
                        [
                            'label' => 'Parametros',
                            'icon' => 'cogs',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Flota',
                                    'icon' => 'truck',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Marcas de vehículos', 'icon' => 'car', 'url' => ['marcas-vehiculos/'],],
                                        ['label' => 'Lineas de los vehiculos', 'icon' => 'linode', 'url' => ['/lineas-marcas'],],
                                        ['label' => 'Tipos de vehículos', 'icon' => 'car', 'url' => ['tipos-vehiculos/'],],
                                        ['label' => 'Zonas', 'icon' => 'book', 'url' => ['zonas-centros-costos/'],],
                                        ['label' => 'Tipos de seguros', 'icon' => 'book', 'url' => ['tipos-seguros/'],],
                                        ['label' => 'Tipos de impuestos', 'icon' => 'book', 'url' => ['/tipos-impuestos'],],
                                        ['label' => 'Tipos Otros Docum.', 'icon' => 'book', 'url' => ['tipos-otros-documentos/'],],
                                        ['label' => 'Tipos de Ingresos', 'icon' => 'info-circle', 'url' => ['tipos-ingresos/'],],
                                        ['label' => 'Tipos de Gastos', 'icon' => 'money', 'url' => ['tipos-gastos/'],],
                                        ['label' => 'Tipos de Combustibles', 'icon' => 'tint', 'url' => ['tipos-combustibles/'],],
                                        ['label' => 'Marca de motores', 'icon' => 'steam', 'url' => ['marcas-motores/'],],
                                        ['label' => 'Líneas de motores', 'icon' => 'cogs', 'url' => ['lineas-motores/'],],
                                        ['label' => 'Motores', 'icon' => 'microchip', 'url' => ['motores/'],],
                                    ],
                                ],
                                [
                                    'label' => 'Checklist',
                                    'icon' => 'check-square',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'Tipos Checklist',
                                            'icon' => 'random',
                                            'url' => ['/tipos-checklist'],
                                        ], ['label' => 'Criterios Evaluación', 'icon' => 'info', 'url' => ['/criterios-evaluaciones'],],
                                        [
                                            'label' => 'Grupos Novedades',
                                            'icon' => 'sticky-note',
                                            'url' => ['/grupos-novedades'],
                                        ],

                                        ['label' => 'Novedades', 'icon' => 'bell', 'url' => ['/novedades'],],
                                        ['label' => 'Estado Checklist', 'icon' => 'check-circle-o', 'url' => ['/estados-checklist'],],
                                        ['label' => 'Estado Configuración', 'icon' => 'check-circle-o', 'url' => ['/estados-checklist-configuracion'],],

                                    ],
                                ],
                                [
                                    'label' => 'Mantenimiento',
                                    'icon' => 'briefcase',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'Etiquetas Mantenimiento',
                                            'icon' => 'gear',
                                            'url' => ['/etiquetas-mantenimientos'],
                                        ],
                                        [
                                            'label' => 'Sistemas/Subsist.',
                                            'icon' => 'laptop',
                                            'items' => [
                                                ['label' => 'Sistemas', 'icon' => 'cogs', 'url' => ['/sistemas'],],
                                                ['label' => 'Subsistemas', 'icon' => 'cog', 'url' => ['/subsistemas'],]
                                            ]
                                        ],
                                        ['label' => 'Tipos de Órdenes', 'icon' => 'archive', 'url' => ['/tipos-ordenes'],],
                                        ['label' => 'Tiempos Muertos', 'icon' => 'clock-o', 'url' => ['/tiempos-muertos'],],
                                        ['label' => 'Tipos de mantenimientos', 'icon' => 'book', 'url' => ['/tipos-mantenimientos'],],
                                        ['label' => 'Unidades de Medida', 'icon' => 'list', 'url' => ['/unidades-medidas'],],
                                        [
                                            'label' => 'Trabajos',
                                            'icon' => 'user',
                                            'url' => '#',
                                            'items' => [
                                                [
                                                    'label' => 'Acciones',
                                                    'icon' => 'book',
                                                    'url' => ['/acciones-trabajos'],
                                                ],
                                                [
                                                    'label' => 'Semáforos',
                                                    'icon' => 'book',
                                                    'url' => ['/semaforos-trabajos'],
                                                ],

                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'label' => 'Inventarios',
                                    'icon' => 'info',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'Ubicación Insumos',
                                            'icon' => 'map-marker',
                                            'url' => ['/ubicaciones-insumos'],
                                        ],
                                        [
                                            'label' => 'Conceptos',
                                            'icon' => 'book',
                                            'url' => ['/conceptos'],
                                        ],
                                        ['label' => 'Grupos Insumos', 'icon' => 'th', 'url' => ['/grupos-insumos'],],
                                        ['label' => 'General Inventario', 'icon' => 'book', 'url' => ['/general-inventario'],],

                                    ],
                                ],
                                [
                                    'label' => 'Proveedores',
                                    'icon' => 'users',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Tipos de Documentos', 'icon' => 'files-o', 'url' => ['/tipos-documentos'],],
                                        ['label' => 'Tipos de Proveedor', 'icon' => 'vcard', 'url' => ['/tipos-proveedores'],],
                                        [
                                            'label' => 'Listado de Proveedores',
                                            'icon' => 'user-o',
                                            'url' => ['/proveedores'],
                                        ],

                                    ],
                                ],
                                [
                                    'label' => 'Empresas',
                                    'icon' => 'building',
                                    'url' => '#',
                                    
                                    'items' => [
                                        ['label' => 'Perfil de empresa', 'icon' => 'building', 'url' => ['/empresas/view?id=' . Yii::$app->user->identity->empresa_id],],
                                        ['label' => 'Centro de costos', 'icon' => 'usd', 'url' => ['/centros-costos'],],
                                        ['label' => 'Cuentas contables', 'icon' => 'university', 'url' => ['/cuentas-contables'],],
                                        ['label' => 'Clientes', 'icon' => 'user', 'url' => ['/clientes'],],
                                        ['label' => 'Tipos de alertas', 'icon' => 'bell', 'url' => ['/alertas-tipos'],],
                                        ['label' => 'Alertas', 'icon' => 'envelope-square', 'url' => ['/alertas-usuarios'],],
                                    ],
                                ],
                                [
                                    'label' => 'Personal',
                                    'icon' => 'user-circle-o',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Usuarios', 'icon' => 'users', 'url' => ['/user'],],
                                        ['label' => 'Tipos de usuarios', 'icon' => 'server', 'url' => ['/tipos-usuarios'],],
                                        ['label' => 'Tipos de documentos', 'icon' => 'address-card', 'url' => ['/usuarios-documentos'],],

                                    ],
                                ]
                            ],
                        ],
                        [
                            'label' => 'Flota',
                            'icon' => 'truck',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Catalogo vehiculos', 'icon' => 'file', 'url' => ['/vehiculos'],],
                                ['label' => 'Checklist', 'icon' => 'check-square', 'url' => ['/checklist'],],
                                ['label' => 'Administrar Mediciones', 'icon' => 'bar-chart', 'url' => ['/mediciones'],],
                                ['label' => 'Combustible', 'icon' => 'tint', 'url' => ['/combustibles'],],
                                ['label' => 'Otros Gastos', 'icon' => 'money', 'url' => ['/otros-gastos'],],
                                ['label' => 'Otros Ingresos', 'icon' => 'bank', 'url' => ['/otros-ingresos'],],
                            ],
                        ],
                        [
                            'label' => 'Mantenimiento',
                            'icon' => 'briefcase',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Orden de trabajo', 'icon' => 'share', 'url' => ['/ordenes-trabajos'],],
                                ['label' => 'Novedades Mantenimiento', 'icon' => 'bell', 'url' => ['/novedades-mantenimientos'],],
                                ['label' => 'Programar Mantenimiento', 'icon' => 'clock-o', 'url' => ['/mantenimientos'],],
                                ['label' => 'Trabajos', 'icon' => 'industry', 'url' => ['/trabajos'],],
                                ['label' => 'Repuestos', 'icon' => 'puzzle-piece', 'url' => ['/repuestos'],],
                                ['label' => 'Rutinas', 'icon' => 'calendar', 'url' => ['/rutinas'],],
                            ],
                        ],
                        [
                            'label' => 'Inventario',
                            'icon' => 'info',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Solicitudes y Cotizaciones', 'icon' => 'list-ul', 'url' => ['/solicitudes'],],
                                ['label' => 'Ordenes de Compra', 'icon' => 'check-square-o', 'url' => ['/ordenes-compras'],],
                                ['label' => 'Traslados', 'icon' => 'truck', 'url' => ['/traslados'],],
                                ['label' => 'Compras', 'icon' => 'shopping-cart', 'url' => ['/compras'],],
                                ['label' => 'Inventario Fisico', 'icon' => 'tasks', 'url' => ['/inventarios'],],
                                ['label' => 'Ajustes', 'icon' => 'cog', 'url' => ['/inventarios-ajustes'],],
                            ],
                        ],
                        [
                            'label' => 'Consultas',
                            'icon' => 'file-text',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Personal',
                                    'icon' => 'user',
                                    'url' => ['/user/consulta-personal'],
                                    'items' => []
                                ],
                                [
                                    'label' => 'Flota',
                                    'icon' => 'truck',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Consulta General', 'icon' => 'search', 'options' => ['title' => 'Consulta General'], 'url' => ['/vehiculos/flota-general'],],
                                        ['label' => 'Costos por Medición', 'icon' => 'money', 'options' => ['title' => 'Costos por Medición'], 'url' => ['/vehiculos/costos-medicion'],],
                                        ['label' => 'Gestion Documental', 'icon' => 'files-o', 'options' => ['title' => 'Gestion Documental'], 'url' => ['/vehiculos/gestion-documental'],],
                                        ['label' => 'Otros Gastos', 'icon' => 'money', 'options' => ['title' => 'Otros Gastos'], 'url' => ['/vehiculos/otros-gastos'],],
                                        ['label' => 'Otros Ingresos', 'icon' => 'bank', 'options' => ['title' => 'Otros Ingresos'], 'url' => ['/vehiculos/otros-ingresos'],],
                                        ['label' => 'Admin de Mediciones', 'icon' => 'thermometer', 'options' => ['title' => 'Admin de Mediciones'], 'url' => ['/vehiculos/flota-mediciones'],],
                                        ['label' => 'Conductores', 'icon' => 'user-o', 'options' => ['title' => 'Conductores'], 'url' => ['/vehiculos/flota-conductores'],],
                                        ['label' => 'Trabajo Realizado Vehic...', 'icon' => 'car', 'options' => ['title' => 'Trabajo Realizado por Vehículos'], 'url' => ['/vehiculos/recorrido-vehiculos'],],

                                    ]
                                ],
                                [
                                    'label' => 'Checklist',
                                    'icon' => 'check-square',
                                    'url' => Url::to(['/checklist/consulta']),
                                    'items' => []
                                ],
                                [
                                    'label' => 'Combustible',
                                    'icon' => 'tint',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Hist. Rendimiento Vehic.', 'icon' => 'search', 'options' => ['title' => 'Hist. Rendimiento Vehic.'], 'url' => ['/combustibles/combustible-rendimiento-vehiculo'],],
                                        ['label' => 'Hist. Rendimiento Flota', 'icon' => 'files-o', 'options' => ['title' => 'Hist. Rendimiento Flota'], 'url' => ['/combustibles/combustible-rendimiento-flota'],],
                                        ['label' => 'Hist. Rend Flota Días', 'icon' => 'money', 'options' => ['title' => 'Hist. Rendimiento Flota Días'], 'url' => ['/combustibles/combustible-rendimiento-flota-detalle'],],
                                        ['label' => 'Costos Agrup. (Cencos)', 'icon' => 'bank', 'options' => ['title' => 'Costos Agrup. (Cencos)'], 'url' => ['/combustibles/combustible-centros-costos'],],
                                        ['label' => 'Costos Agrup. Proveedor', 'icon' => 'thermometer', 'options' => ['title' => 'Costos Agrup. Proveedor'], 'url' => ['/combustibles/combustible-proveedor'],],
                                        ['label' => 'Detalle por Proveedor', 'icon' => 'user-o', 'options' => ['title' => 'Detalle por Proveedor'], 'url' => ['/combustibles/combustible-detalle-proveedor'],],
                                        ['label' => 'Agrup.Vehículo,Ruta,Prov.', 'icon' => 'user-o', 'options' => ['title' => 'Agrup. Vehículo, Ruta, Prov.'], 'url' => ['/combustibles/combustible-vehiculo-proveedor'],],
                                    ]
                                ],
                                [
                                    'label' => 'Mantenimiento',
                                    'icon' => 'briefcase',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Costo Ordenes de tra...', 'icon' => 'share', 'options' => ['title' => 'Costo Ordenes de trabajos'], 'url' => ['/mantenimientos/costo-ordenes-trabajos'],],
                                        ['label' => 'Trabajos de las Orde...', 'icon' => 'wrench', 'options' => ['title' => 'Trabajos de las Ordenes de Trabajos'], 'url' => ['/mantenimientos/ordenes-trabajos-trabajo'],],
                                        ['label' => 'Repuestos de las Ord...', 'icon' => 'cogs', 'options' => ['title' => 'Repuestos de las Ordenes de Trabajos'], 'url' => ['/mantenimientos/ordenes-trabajos-repuesto'],],
                                        ['label' => 'Programacion de Mant...', 'icon' => 'clock-o', 'options' => ['title' => 'Programacion de Mantenimientos'], 'url' => ['/mantenimientos/programacion-mantenimiento'],],
                                        ['label' => 'Duracion de Novedade...', 'icon' => 'bell', 'options' => ['title' => 'Duracion de Novedades de Mantenimientos'], 'url' => ['/mantenimientos/novedad-mantenimiento-dias'],],
                                        ['label' => 'Trabajos por Tipos d...', 'icon' => 'industry', 'options' => ['title' => 'Trabajos por Tipos de Mantenimientos'], 'url' => ['/mantenimientos/trabajo-tipos-mantenimientos'],],
                                        ['label' => 'Mantenimientos por V...', 'icon' => 'car', 'options' => ['title' => 'Mantenimientos por Vehiculo'], 'url' => ['/mantenimientos/mantenimiento-vehiculos'],],
                                        ['label' => 'Repuestos por Provee...', 'icon' => 'user', 'options' => ['title' => 'Repuestos por Proveedor'], 'url' => ['/mantenimientos/repuestos-proveedor'],],
                                        ['label' => 'Repuestos por Ubicac...', 'icon' => 'map', 'options' => ['title' => 'Repuestos por Ubicaciones'], 'url' => ['/mantenimientos/repuestos-inventariables'],],
                                        ['label' => 'Caracteristicas Repu...', 'icon' => 'cog', 'options' => ['title' => 'Caracteristicas Repuestos'], 'url' => ['/mantenimientos/repuestos'],],
                                        ['label' => 'Costo Trabajos por t...', 'icon' => 'dollar', 'options' => ['title' => 'Costo Trabajos por tipo de vehiculos'], 'url' => ['/mantenimientos/costo-trabajos-tipo-vehiculo'],],
                                    ]
                                ],
                                [
                                    'label' => 'Inventario',
                                    'icon' => 'info',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Reporte de cotizaciones', 'icon' => 'cog', 'url' => ['/cotizaciones/cotizaciones-consulta'],],
                                        ['label' => 'Informe ajustes de repues...', 'icon' => 'cog', 'url' => ['/inventarios-ajustes/inventario-ajustes-consulta'],],
                                        ['label' => 'Solicitudes de insumos', 'icon' => 'cog', 'url' => ['/solicitudes/solicitudes-consulta'],],
                                        ['label' => 'Informe de existencias', 'icon' => 'cog', 'url' => ['/repuestos/ubicacion-repuestos-consulta'],],
                                        ['label' => 'Informe detallado de repuestos', 'icon' => 'cog', 'url' => ['/repuestos/repuestos-consulta'],],
                                    ]
                                ],
                            ],
                        ],
                        ['label' => 'Empresas', 'icon' => 'building', 'url' => ['/empresas'], 'visible' => Yii::$app->user->can('r-super-admin')],

                    ],
                ]
            )
        ?>

    </section>

</aside>