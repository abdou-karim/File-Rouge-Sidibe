<?php

namespace App\Security\Voter;

use App\Entity\GroupeCompetences;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class GroupeCompetencesVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports($attribute, $groupeCompetence)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_EDIT', 'GROUPE_COMPETENCE_READ'])
            && $groupeCompetence instanceof GroupeCompetences;
    }

    protected function voteOnAttribute($attribute, $groupeCompetence, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {

            case 'GROUPE_COMPETENCE_READ':

                if ( $user->getRoles()[0]==="ROLE_Administrateur" || $user->getRoles()[0]==="ROLE_Formateur" || $user->getRoles()[0]==="ROLE_Community Manager"  )
                { return true; }
             break;
            case 'POST_VIEW':
                if ( $user->getRoles()[0]==="ROLE_Administrateur")
                { return true; }
                break;
        }

        return false;
    }
}
