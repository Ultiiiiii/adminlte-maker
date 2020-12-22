<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $entity_full_class_name ?>;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class <?= $class_name ?> extends <?= $parent_class_name; ?> implements <?= $interface_class_name; ?><?= "\n" ?>
{

    public function configure(DataTable $dataTable, array $options){
        $dataTable
<?php
    foreach ($entity_fields as $field){
        echo "\t\t";
        switch ($field['type']) {
            case 'boolean':
                echo "->add('" . $field['fieldName'] ."', BoolColumn::class, [
                    'trueValue' => \$options['translator']->trans('Yes'),
                    'falseValue' => \$options['translator']->trans('No'),
                    'nullValue' => \$options['translator']->trans('Unknown'),
                ])" . PHP_EOL;
                break;

            case 'datetime':
                echo "->add('" . $field['fieldName'] ."', DateTimeColumn::class, [
                    'format' => 'd/m/Y H:i',
                ])" . PHP_EOL;
                break;

            case 'integer':
            case 'text':
            case 'string':
            default:
                echo "->add('" . $field['fieldName'] ."', TextColumn::class)" . PHP_EOL;
                break;
        }
    }
?>
        ->add('link', TextColumn::class, [
            'data' => function (<?= $entity_class_name ?> $<?= strtolower($entity_class_name); ?>) use ($options)  {
                return sprintf('<a class="btn btn-primary btn-xs" href="%s"><i class="fa fa-search"></i>  '.$options['translator']->trans('Show').'</a>',
                    $this->generateUrl('<?= $route_name ?>_show', ['id' => $<?= strtolower($entity_class_name); ?>->getId()])
                );
            },
            'raw' => true
        ])
        ->createAdapter(ORMAdapter::class, [
            'entity' => <?= $entity_class_name ?>::class,
        ]);
    }
}