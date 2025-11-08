<?php  
    namespace App\Form;

    use App\Entity\User;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class UserType extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options) {

            $builder->add("name", TextType::class)
                ->add("email", EmailType::class)
                ->add("phone", TextType::class)
                ->add("type", TextType::class)
                ->add("isActive", CheckboxType::class, ["label" => "¿Está activo?", "required" => false])
                ->add("save", SubmitType::class, ["label" => "Guardar"]);

        }

        public function configureOptions(OptionsResolver $resolver) {

            $resolver->setDefaults(["data_class" => User::class]);

        }

    }