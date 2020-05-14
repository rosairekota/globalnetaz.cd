<?php 
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Entity\User;
/**
 * 
 */
class UserRegistrationType  extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	    $builder
	        ->add('username', null, ['label'=>'Nom d\'utilisateur'])
	        ->add('password', PasswordType::class, ['label'=>'Mot de Passe'])
	        ->add('password_confirm', PasswordType::class, ['label'=>'Confirmer le Mot de Passe'])
	    ;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults([
	        'data_class' => User::class,
	    ]);
	}
}