<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $entity_full_class_name ?>;
use <?= $form_full_class_name ?>;
<?php if (isset($repository_full_class_name)): ?>
use <?= $repository_full_class_name ?>;
<?php endif ?>
use Symfony\Bundle\FrameworkBundle\Controller\<?= $parent_class_name ?>;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\DataTableFactory;

/**
 * @Route("<?= $route_path ?>")
 */
class <?= $class_name ?> extends <?= $parent_class_name; ?><?= "\n" ?>
{
    /**
     * @Route("/", name="<?= $route_name ?>_index", methods={"GET", "POST"})
     */
<?php if (isset($repository_full_class_name)): ?>
    public function index(Request $request, DataTableFactory $dataTableFactory, TranslatorInterface $translator, EntityManagerInterface $em, <?= $repository_class_name ?> $<?= $repository_var ?>): Response
    {
        $table = $dataTableFactory->create();
<?php
            foreach ($entity_fields as $field){
                echo "\t\t";
                switch ($field['type']) {
                    case 'boolean':
                        echo "\$table->add('" . $field['fieldName'] ."', BoolColumn::class, [
                            'trueValue' => \$translator->trans('Yes'),
                            'falseValue' => \$translator->trans('No'),
                            'nullValue' => \$translator->trans('Unknown'),
                        ]);" . PHP_EOL;
                        break;

                    case 'datetime':
                        echo "\$table->add('" . $field['fieldName'] ."', DateTimeColumn::class, [
                            'format' => 'd/m/Y H:i',
                        ]);" . PHP_EOL;
                        break;

                    case 'integer':
                    case 'text':
                    case 'string':
                    default:
                        echo "\$table->add('" . $field['fieldName'] ."', TextColumn::class);" . PHP_EOL;
                        break;
                }
            }
        ?>

        $table->add('link', TextColumn::class, [
        'data' => function (<?= $entity_class_name ?> $<?= strtolower($entity_class_name); ?>) use ($translator) {
            return sprintf('<a class="btn btn-primary btn-xs" href="%s"><i class="fa fa-search"></i>  '.$translator->trans('Show').'</a>', $this->generateUrl('<?= $route_name ?>_show', [
                'id' => $<?= strtolower($entity_class_name); ?>->getId(),
            ]) );
        },
        'raw' => true,
    ]);

        $table->createAdapter(ORMAdapter::class, [
            'entity' => <?= $entity_class_name ?>::class,
        ])->handleRequest($request);
            
        if ($table->isCallback()) {
            return $table->getResponse();
        }

        // new modal form
        $<?= $entity_var_singular ?> = new <?= $entity_class_name; ?>();
        $form = $this->createForm(<?= $entity_class_name; ?>Type::class, $<?= $entity_var_singular ?>);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($<?= $entity_var_singular ?>);
                $em->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $translator->trans('Error saving item'));
                return $this->redirectToRoute('<?= $entity_var_singular ?>_index');
            }
                $this->addFlash('success', $translator->trans('Item successfully registered'));
                return $this->redirectToRoute('<?= $entity_var_singular ?>_index');
        }

        return $this->render('<?= $templates_path ?>/index.html.twig', [
            '<?= $entity_twig_var_plural ?>' => $<?= $repository_var ?>->findAll(),
            'datatable' => $table,
            'modal' => [
                '<?= $entity_var_singular ?>' => $<?= $entity_var_singular ?>,
                'form'  => $form->createView(),
                'title' => $translator->trans('Create new item'),
                'footer' => '
                <div class="pull-right"><button type="submit" class="btn btn-primary" href="'.$this->generateUrl('<?= $entity_var_singular ?>_index').'"><i class="fa fa-plus-square"></i> '.$translator->trans('Create new').'</button></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">'.$translator->trans('Close').'</button>
                ',
            ]
        ]);
    }
<?php else: ?>
    public function index(): Response
    {
        $<?= $entity_var_plural ?> = $this->getDoctrine()
            ->getRepository(<?= $entity_class_name ?>::class)
            ->findAll();

        return $this->render('<?= $templates_path ?>/index.html.twig', [
            '<?= $entity_twig_var_plural ?>' => $<?= $entity_var_plural ?>,
        ]);
    }
<?php endif ?>



    /**
     * @Route("/{<?= $entity_identifier ?>}", name="<?= $route_name ?>_show", methods={"GET","POST"})
     */
    public function show(<?= $entity_class_name ?> $<?= $entity_var_singular ?>, Request $request, TranslatorInterface $translator, EntityManagerInterface $em): Response
    {
        // Edit modal form
        $form = $this->createForm(<?= $entity_class_name ?>Type::class, $<?= $entity_var_singular ?>);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $translator->trans('Error editing item'));
                return $this->redirectToRoute('<?= $entity_var_singular ?>_show',['<?= $entity_identifier ?>'=>$<?= $entity_var_singular ?>->get<?= ucfirst($entity_identifier) ?>()]);
            }
            $this->addFlash('success', $translator->trans('Item successfully edited'));
            return $this->redirectToRoute('<?= $entity_var_singular ?>_index');
        }
        return $this->render('<?= $templates_path ?>/show.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'modal' => [
                '<?= $entity_var_singular ?>' => $<?= $entity_var_singular ?>,
                'form'  => $form->createView(),
                'title' => $translator->trans('Edit item'),
                'footer' => '
                <div class="pull-right"><button type="submit" class="btn btn-primary" href="'.$this->generateUrl('<?= $entity_var_singular ?>_show',['<?= $entity_identifier ?>'=>$<?= $entity_var_singular ?>->get<?= ucfirst($entity_identifier) ?>()]).'"><i class="fa fa-save"></i> '.$translator->trans('Save').'</button></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">'.$translator->trans('Close').'</button>
                ',
            ],
            'modalDelete' => [
            'title' => $translator->trans('Delete item'),
            'message' => '<p><br>'.$translator->trans('Are you sure you want to delete this item').' ?<br></p>',
            ],
        ]);
    }


    /**
     * @Route("/{<?= $entity_identifier ?>}/delete/{token}", name="<?= $route_name ?>_delete", methods={"GET"})
     */
    public function delete(Request $request, <?= $entity_class_name ?> $<?= $entity_var_singular ?>, $token, EntityManagerInterface $em, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$<?= $entity_var_singular ?>->get<?= ucfirst($entity_identifier) ?>(), $token)) {
            try {
                $em->remove($<?= $entity_var_singular ?>);
                $em->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $translator->trans('Error deleting item'));
                return $this->redirectToRoute('<?= $route_name ?>_index');
            }
            $this->addFlash('success', $translator->trans('Item successfully deleted'));
            return $this->redirectToRoute('<?= $route_name ?>_index');            
        }

        $this->addFlash('error', $translator->trans('Error deleting item'));
        return $this->redirectToRoute('<?= $route_name ?>_index');
    }
}
