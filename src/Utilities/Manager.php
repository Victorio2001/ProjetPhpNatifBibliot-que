<?php

namespace MonApp\Utilities;

class Manager
{

    /**
     * L'espace de nom par défaut contenant les entités
     * @var string
     */
    private static string $defaultEntitiesNameSpace = 'Entities';

    /**
     * L'espace de nom par défaut contenant les repositories
     * @var string
     */
    private static string $defaultRepositoriesNameSpace = 'Repositories';

    /**
     * Le tableau des repositories
     * @var Array
     */
    private static array $repositories = [];

    /**
     * Récupère (ou instancie) le repository de l'entité en paramètre
     * @param string $entityName le nom de l'entité.
     * Il peut être complet (avec espaces de nom) ou simple pour utiliser les attributs.
     * @param string|null $otherBaseNameSpace Vous pouvez préciser l'espace de nom de base, si différent de celui en attribut
     * @return \Phaln\AbstractRepository le repository de l'entité
     * @throws Exceptions\ManagerException
     */
    public static function getRepository(string $entityName) {
        if (DUMP) {
            echo '<p>Les repos existants</p>';
            dump(self::$repositories);
        }
        // On peut éventuellement avoir des entités dans d'autres espace de nom de base que celui par défaut.
        $saveEntityName = (class_exists($entityName)) ? $entityName : self::$defaultEntitiesNameSpace . '\\' . $entityName;

        if (!isset(self::$repositories[$saveEntityName])) {
            //  S'il n'y a pas de repository pour cette entité dans le tableau, on l'instancie
            $repoName = self::$defaultRepositoriesNameSpace . '\\' . $entityName . 'Repository';
            if (class_exists($repoName) && class_exists($saveEntityName)) {
                self::$repositories[$saveEntityName] = new $repoName();
            } else {
                throw new Exceptions("$repoName inexistant.");
            }
        }
        return self::$repositories[$saveEntityName];
    }
}