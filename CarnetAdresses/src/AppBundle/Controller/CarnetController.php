<?php
	namespace AppBundle\Controller ;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller ;
	use Symfony\Component\HttpFoundation\Request ;
	use Symfony\Component\HttpFoundation\JsonResponse ;

	use AppBundle\Entity\Utilisateur ;

	class CarnetController extends Controller
	{
		public function createAction (Request $request)
		{
			$em=$this->getDoctrine ()->getManager () ;
			$utilisateur=new Utilisateur () ;
			$utilisateur->setNom ($request->query->get ("nom")) ;
			$utilisateur->setPrenom ($request->query->get ("prenom")) ;
			$utilisateur->setMail ($request->query->get ("mail")) ;
			$utilisateur->setAdresse ($request->query->get ("adresse")) ;
			$utilisateur->setTel ($request->query->get ("tel")) ;
			$utilisateur->setSiteWeb ($request->query->get ("siteWeb")) ;
			$em->persist ($utilisateur) ;
			$em->flush () ;
			return new JsonResponse () ;
		}

		public function retrieveAction ($id)
		{
			$repository=$this->getDoctrine ()->getManager ()->getRepository ("AppBundle:Utilisateur") ;
			$utilisateur=$repository->find ($id) ;
			return new JsonResponse (array ("id" => $utilisateur->getId (),
											"nom" => $utilisateur->getNom (),
											"prenom" => $utilisateur->getPrenom (),
											"mail" => $utilisateur->getMail (),
											"adresse" => $utilisateur->getAdresse (),
											"tel" => $utilisateur->getTel (),
											"siteWeb" => $utilisateur->getSiteWeb ())) ;
		}

		public function updateAction ($id, Request $request)
		{
			$em=$this->getDoctrine ()->getManager () ;
			$repository=$em->getRepository ("AppBundle:Utilisateur") ;
			$utilisateur=$repository->find ($id) ;
			$utilisateur->setNom ($request->query->get ("nom")) ;
			$utilisateur->setPrenom ($request->query->get ("prenom")) ;
			$utilisateur->setMail ($request->query->get ("mail")) ;
			$utilisateur->setAdresse ($request->query->get ("adresse")) ;
			$utilisateur->setTel ($request->query->get ("tel")) ;
			$utilisateur->setSiteWeb ($request->query->get ("siteWeb")) ;
			$em->persist ($utilisateur) ;
			$em->flush () ;
			return new JsonResponse (array ("id" => $utilisateur->getId (),
											"nom" => $utilisateur->getNom (),
											"prenom" => $utilisateur->getPrenom (),
											"mail" => $utilisateur->getMail (),
											"adresse" => $utilisateur->getAdresse (),
											"tel" => $utilisateur->getTel (),
											"siteWeb" => $utilisateur->getSiteWeb ())) ;
		}

		public function deleteAction ($id)
		{
			$em=$this->getDoctrine ()->getManager () ;
			$repository=$em->getRepository ("AppBundle:Utilisateur") ;
			$utilisateur=$repository->find ($id) ;
			$em->remove ($utilisateur) ;
			$em->flush () ;
			return new JsonResponse ($utilisateur) ;
		}

		public function getAllAction ()
		{
			$repository=$this->getDoctrine ()->getManager ()->getRepository ("AppBundle:Utilisateur") ;
			$listeUtilisateurs=$repository->findAll () ;
			$res=array () ;
			foreach ($listeUtilisateurs as $utilisateur)
			{
				$res[]=array ("id" => $utilisateur->getId (),
							  "nom" => $utilisateur->getNom (),
							  "prenom" => $utilisateur->getPrenom (),
							  "mail" => $utilisateur->getMail (),
							  "adresse" => $utilisateur->getAdresse (),
							  "tel" => $utilisateur->getTel (),
							  "siteWeb" => $utilisateur->getSiteWeb ()) ;
			}
			return new JsonResponse ($res) ;
		}
	}
?>