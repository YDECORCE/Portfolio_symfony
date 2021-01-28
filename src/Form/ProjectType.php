<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title')
            ->add('Description', CKEditorType::class)
            ->add('Image', FileType::class, [
                'label' => 'Image',

        // unmapped means that this field is not associated to any entity property
                'mapped' => false,

        // make it optional so you don't have to re-upload the PDF file
        // every time you edit the Product details
                'required' => false,

        // unmapped fields can't define their validation using annotations
        // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                            'image/png',
                            'image/jpg','image/jpeg','image/gif'
                                ],
                'mimeTypesMessage' => 'Merci d\'uploader un fichier image valide',
                        ])
                            ],
            ])
            ->add('Github', UrlType::class)
            ->add('Weblink', UrlType::class)
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
