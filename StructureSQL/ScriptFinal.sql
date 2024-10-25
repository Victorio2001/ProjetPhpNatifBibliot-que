 

--
-- Structure de la table `role`
--
DROP TABLE IF EXISTS role cascade;
CREATE TABLE IF NOT EXISTS role(
   idRole SERIAL PRIMARY KEY,
   nomRole VARCHAR(100) NOT NULL
);
--
-- Jeux de données de la table 'role'
--
INSERT INTO role (idRole, nomRole) VALUES
(-1, 'gestionnaire'),
(-2, 'formateur'),
(-3, 'etudiant'),
(-4, 'lectureSeule');


--
-- Structure de la table `editeur`
--
DROP TABLE IF EXISTS editeur cascade;
CREATE TABLE IF NOT EXISTS editeur(
   idEditeur SERIAL PRIMARY KEY,
   nomEditeur VARCHAR(50) NOT NULL
);
--
-- Jeux de données de la table 'editeur'
--
INSERT INTO editeur (idEditeur, nomEditeur) VALUES
(-1, 'glenat'),
(-2, 'kaze'),
(-3, 'kioon');

--
-- Structure de la table `livre`
--
DROP TABLE IF EXISTS livre cascade;
CREATE TABLE IF NOT EXISTS livre(
   IdLivre  SERIAL PRIMARY KEY,
   titreLivre VARCHAR(500) NOT NULL,
   resumeLivre VARCHAR(5000) NOT NULL,
   anneePublication DATE NOT NULL,
   nombreExemplaires INT NOT NULL,
   isbn BIGINT UNIQUE NOT NULL,
   imageCouverture VARCHAR(500) DEFAULT 'Default.jpeg'
);
--
-- Jeux de données de la table 'livre'
--
INSERT INTO livre (IdLivre, titreLivre, resumeLivre, anneePublication, nombreExemplaires, isbn, imageCouverture) VALUES
(-1,'Windows Server 2022 - Les bases indispensables pour administrer et configurer votre serveur', 'Ce livre sur Windows Server 2022 s adresse à tout administrateur ou futur administrateur de serveurs Windows. Il a pour objectif de vous donner les bases indispensables pour administrer et configurer votre serveur.', '2022-11-16', 2, 9782409037641, 'ws22-9782409037641-0-front.jpg'),
(-2,'Symfony 5 - Développez des sites web PHP structurés et performants', 'Ce livre sur Symfony 5 s adresse aux développeurs, chefs de projet, architectes techniques, qui souhaitent, grâce à ce framework, structurer et organiser leurs développements PHP au sein d un environnement de construction d applications robuste et professionnel. La maîtrise de la programmation objet avec PHP est un prérequis indispensable pour tirer le meilleur parti de ces pages.', '2022-11-16', 2, 9782409037221, 'sf5-9782409037221-0-front.jpg'),
(-3,'Apache Maven - Maîtrisez l infrastructure d un projet Java EE', 'Ce livre sur Apache Maven (en version 3.6 au moment de l écriture) s adresse à tout développeur amené à travailler sur des projets Java de taille conséquente. Il sert également de guide pour les architectes qui souhaitent mettre en œuvre Apache Maven sur un nouveau projet ou sur un projet existant.', '2019-06-12', 2, 9782409019531, 'am_jee-9782409019531-0-front.jpg'),
(-4,'AWS : Gérez votre infrastructure sur la plateforme cloud d Amazon', 'Cet ouvrage propose un voyage au coeur de la plateforme cloud Amazon Web Services et de ses services lors duquel le lecteur trouvera toutes les informations nécessaires sur la conception, le développement et l administration d une infrastructure AWS. Il s adresse à toute personne qui souhaite explorer les subtilités du cloud computing et des principaux services d AWS pour faire tourner ses applications.', '2019-12-11', 2, 9782409022180, 'aws-9782409022180-0-front.jpg'),
(-5,'C# 10 - Développez des applications Windows avec Visual Studio 2022', 'Ce livre sur le développement d applications Windows avec le langage C# (en version 10) et Visual Studio 2022 est destiné aux développeurs qui débutent avec le framework .NET. Il leur permet d apprendre les bases du langage C# et introduit des concepts plus avancés leur donnant une vue d ensemble des possibilités offertes par le langage C#, Visual Studio et le framework .NET en général. L auteur a choisi une approche pas à pas tout en construisant une application fonctionnelle tout au long de l ouvrage pour illustrer de manière pratique et cohérente les concepts abordés.', '2022-04-13', 2, 9782409035135, 'c#_vs-9782409035135-0-front.jpg'),
(-6,'Conduite de projets informatiques - Développement, analyse et pilotage', 'Ce livre sur la conduite de projets informatiques s’adresse à un public d’informaticiens, de chefs de projet, qu’ils soient professionnels ou étudiants. Il présente la conduite de projets d’une façon concrète et abordable, en fournissant les éléments clés d’un projet réussi : analyse, suivi, bilan.', '2022-10-12', 2, 9782409037368, 'cpi-9782409037368-0-front.jpg'),
(-7,'Docker - Concepts fondamentaux et déploiement d applications conçues en services', 'Ce livre s’adresse aux développeurs, architectes et administrateurs système, ainsi qu’à toute personne désireuse de comprendre les concepts fondamentaux de la technologie Docker, sans entrer dans toutes ses subtilités ni tous ses cas d’usage, pour les mettre en œuvre dans le déploiement d’applications conçues en services.', '2022-12-14', 2, 9782409038068, 'docker-9782409038068-0-front.jpg'),
(-8,'Cybersécurité et PowerShell: De l attaque à la défense du système d information', 'Ce livre traite de la sécurité des systèmes d’information à travers le prisme du langage PowerShell. Il s’adresse aux administrateurs système et réseau, experts ou consultants en cybersécurité, chefs de projet ou responsables cyber qui souhaitent comprendre le rôle et les capacités du langage de scripting de Microsoft dans le domaine de la cybersécurité.', '2022-02-09', 2, 9782409034145, 'cs_ps-9782409034145-0-front.jpg'),
(-9,'Design Patterns en Java - Descriptions et solutions illustrées en UML 2 et Java - Les 23 modèles de conception', 'Ce livre présente de façon concise et pratique les 23 modèles de conception (design patterns) fondamentaux en les illustrant par des exemples pertinents et rapides à appréhender. Chaque exemple est décrit en UML et en Java sous la forme d un petit programme complet et exécutable. Pour chaque pattern, l auteur détaille son nom, le problème correspondant, la solution apportée, ses domaines d application et sa structure générique.', '2022-11-16', 2, 9782409037603, 'dp_java-9782409037603-front-0.jpg'),
(-10,'Débuter avec PowerShell', 'Le langage de scripting PowerShell permettant l automatisation d un certain nombre de tâches facilite le quotidien des informaticiens. Que vous soyez étudiants, techniciens, administrateurs système, ingénieurs ou que vous souhaitiez simplement découvrir ce qu est PowerShell, ce livre vous permettra d apprendre les bases du langage en partant de zéro et de découvrir l étendue de ses possibilités.', '2023-04-12', 2, 9782409039645, 'ps-9782409039645-0-front.jpg'),
(-11,'Écrire du code .NET performant - Profilage, benchmarking et bonnes pratiques', 'Ce livre sur la performance du code .NET s’adresse aux développeurs débutants comme expérimentés qui ont à faire face à des problèmes de performances sur leurs développements.', '2022-06-08', 2, 9782409036132, 'dot_net-9782409036132-0-front.jpg'),
(-12,'PostgreSQL', 'L utilisateur de bases de données trouvera dans ce livre les informations indispensables pour exploiter au mieux les possibilités de PostgreSQL (en version 12 au moment de la rédaction).', '2020-04-22', 2, 9782409024504, 'pgsql-9782409024504-0-front.jpg'),
(-13,'PRINCE2® - Une méthode pour maîtriser la gestion de vos projets', 'Ce livre sur PRINCE2® propose aux lecteurs d acquérir une bonne compréhension de la méthodologie PRINCE2® dans sa 6e édition. Il leur permettra de découvrir l intérêt d une méthode de gestion de projet structurée et de comprendre les avantages d une approche processus pour assurer le contrôle d un projet.', '2023-01-11', 2, 9782409038327, 'prince2-9782409038327-0-front.jpg'),
(-14,'Prometheus et Grafana - Surveillez vos applications et composants système', 'Avec ce livre, illustré par de nombreux exemples de mise en œuvre, les administrateurs système comme les développeurs apprendront à déployer l outil de surveillance Prometheus, interfacé avec l outil de visualisation de données Grafana, pour mieux maîtriser la surveillance de leurs applications ou de leurs composants système.', '2021-12-08', 2, 9782409031748, 'pg-9782409031748-0-front.jpg'),
(-15,'Red Hat Enterprise Linux - CentOS - Mise en production et administration de serveurs', 'Ce livre sur Red Hat Enterprise Linux et CentOS, ainsi que Rocky Linux (versions 8 et 9) s adresse à tout informaticien appelé à déployer un serveur Linux performant en entreprise et à en assurer l administration. Émaillé d explications pédagogiques, d exemples et d astuces, ce livre va à l essentiel, fournit des méthodes techniques et logistiques, présente les bonnes pratiques et n oublie pas la sécurité.', '2022-12-14', 2, 9782409037726, 'rh_centos-9782409037726-0-front.jpg'),
(-16,'Python 3 - Les fondamentaux du langage', 'Ce livre sur les fondamentaux du langage Python 3 (en version 3.8 beta au moment de l écriture) s adresse à tout professionnel de l informatique, ingénieur, étudiant (et particulièrement en BTS Services Informatiques Organisations), enseignant ou même autodidacte qui souhaite maîtriser ce langage très abouti. Il couvre un périmètre relativement large, détaille tout le coeur du langage et du traitement de données et ouvre des perspectives importantes sur tout ce que Python 3 permet de faire (de la création d un site web au développement de jeux en passant par la conception d une interface graphique avec Gtk).', '2019-10-09', 2, 9782409020964, 'python-9782409020964-0-front.jpg'),
(-17,'React', 'Ce livre s adresse aux développeurs qui souhaitent lever la complexité apparente du framework Front End React pour réaliser des applications web et mobiles bien architecturées et aisées à maintenir. Pour bien appréhender la lecture de ce livre, un minimum de connaissances sur le langage JavaScript, et en particulier sur les nouveautés apportées par ES2015, est un plus.', '2020-01-15', 2, 9782409022722, 'react-9782409022722-0-front.jpg'),
(-18,'Scripting Python sous Linux - Développez vos outils système', 'Ce livre s adresse aux ingénieurs système qui souhaitent écrire leurs propres outils d administration d un système Linux à l aide du langage Python. Articulé en trois parties, ce livre donne les explications nécessaires au lecteur, suivies d exemples concrets de difficulté croissante, pour ainsi étendre les possibilités du shell. La connaissance d un autre langage de programmation, d un système Linux (quelle que soit la distribution) et des principes de base d Unix est un plus pour la lecture de ce livre.', '2020-06-10', 2, 9782409025679, 'python-9782409025679-0-front.jpg'),
(-19,'Gestion d un projet web - Planification, pilotage et bonnes pratiques', 'Ce livre sur la gestion d un projet web s adresse à tout public tant son approche fonctionnelle en facilite la prise en main. Il apporte une méthodologie de conduite de projet, basée sur l expérience de l auteur, qui passe en revue toutes les étapes fondamentales du cycle de vie d un projet web.', '2019-05-15', 2, 9782409019128, 'gpw-9782409019128-0-front.jpg'),
(-20,'Java Spring - Le socle technique des applications Jakarta EE', 'Ce livre apporte les éléments clés pour se repérer dans les différentes technologies utilisées dans les projets basés sur Spring. Il prend en compte les différences de configuration liées aux versions de Spring (en version 4.3 et 5.3 au moment de l’écriture) et se base sur des exemples concrets d’utilisation. Il permet au lecteur d’être très rapidement autonome sur un projet d’entreprise qui utilise Spring, que ce soit au début d’un nouveau projet ou pour maintenir un projet existant : compréhension du noyau, accès aux données, maîtrise de la couche web. Des connaissances sur le développement Java et notamment le développement d’applications web sont un prérequis indispensable pour tirer le meilleur parti possible du livre.', '2022-08-17', 2, 9782409036552, 'java_s-9782409036552-0-front.jpg'),
(-21,'JavaScript - Développez efficacement', 'Ce livre sur JavaScript s adresse à des développeurs soucieux de progresser dans leurs compétences JavaScript et de passer de la maîtrise syntaxique à la maîtrise du cycle de développement complet. Une première expérience du développement avec JavaScript, dans sa syntaxe de base, est indispensable à la bonne compréhension de cet ouvrage.', '2023-01-11', 2, 9782409038341, 'js-9782409038341-0-front.jpg'),
(-22,'La sécurité sous Windows 11 - Renforcez votre système d exploitation', 'Ce livre s’adresse aux responsables des systèmes d’information des entreprises ainsi qu’à toute personne désireuse d’optimiser la sécurité de son système d’exploitation. Il apporte les connaissances nécessaires à la compréhension et à la maîtrise de la sécurité sous Windows 11.', '2022-10-12', 2, 9782409037429, 's_w11-9782409037429-0-front.jpg'),
(-23,'Le cloud privé avec OpenStack - Guide pratique pour l architecture, l administration et l implémentation', 'Cet ouvrage sur OpenStack, plateforme open source permettant de créer et gérer des infrastructures cloud, a pour objectif d’outiller le lecteur pour le rendre autonome dans son utilisation quotidienne ou pour une implémentation en entreprise. Il se propose de démythifier OpenStack avec une approche par la pratique grâce au retour d’expérience de l’auteur.', '2023-04-12', 2, 9782409038693, 'cpos-9782409038693-0-front.jpg'),
(-24,'SQL - Les fondamentaux du langage (avec exercices et corrigés)', 'Ce livre sur les fondamentaux du langage SQL s adresse aux développeurs et informaticiens débutants appelés à travailler avec un Système de Gestion de Bases de Données Relationnelles (SGBDR) pour stocker et manipuler des données. Son objectif est de décrire les ordres principaux les plus utilisés du langage SQL (indépendamment des déclinaisons réalisées par les éditeurs de SGBDR) pour permettre au lecteur de prendre en main rapidement une base de données relationnelle et être capable de créer des tables, de les interroger, de les modifier, d insérer et de supprimer des lignes.', '2020-09-16', 2, 9782409026553, 'sql-9782409026553-0-front.jpg'),
(-25,'Intelligence Artificielle - Impact sur les entreprises et le business', 'L Intelligence Artificielle ou IA est au coeur de nombreux débats et est le fer de lance de beaucoup d’entreprises. Il ne se passe plus une journée sans qu une communication ne soit faite sur une nouvelle intelligence artificielle capable d en faire plus que la précédente. La guerre industrielle est lancée et on peut facilement imaginer qu elle ne se terminera que par une entité artificielle égale ou supérieure à l humain. C est dans ce nouveau monde qui se prépare qu apparaît la branche cognitive de l intelligence artificielle qui s appuie sur des domaines et outils tels que l apprentissage et l auto-apprentissage, les réseaux de neurones, la langue naturelle, les arbres de décision dont les objectifs sont de déduire des faits marquants, repérer des motifs, prédire des tendances, imaginer de nouveaux services à mettre en place et ainsi aider l humain à décider. Mais cela ne se fait pas sans inquiétudes, tout d abord les biais qui peuvent fausser les interprétations et donc les décisions et ensuite l impact que l intelligence artificielle va avoir sur nos activités, nos rôles et nos métiers.', '2022-12-14', 2, 9782409038006, 'IA-9782409038006-0-front.jpg'),
(-26,'La transformation digitale des entreprises - Plongez de l autre côté du miroir', 'La transformation digitale des entreprises, terme popularisé dans les années 2016, reste, encore aujourd hui, un sujet d actualité empreint de nombreuses attentes qui ont du mal à porter leurs fruits. Les raisons sont nombreuses : une mauvaise compréhension du sujet, une problématique d organisation, une erreur dans les objectifs fixés etc.', '2021-09-15', 2, 9782409031953, 'trs_dig-9782409031953-0-front.jpg'),
(-27,'Cloud privé, hybride et public - Quel modèle pour quelle utilisation ? Un état de l art et des bonnes pratiques', 'Le cloud est très souvent utilisé sans vraiment que l on s en rende compte. Cependant, il n est ni la panacée à tous les défis des entreprises, ni le démon qui ouvre la porte à tous les risques sécuritaires. Dans ce livre qui s adresse aux dirigeants ou aux directeurs des systèmes d information, l auteur apporte un éclairage teinté d expérience sur les questions et les réponses à apporter pour utiliser le cloud avec succès.', '2018-02-14', 2, 9782409012426, 'cl_pr-9782409012426-0-front.jpg'),
(-28,'Intelligence artificielle - Enjeux éthiques et juridiques', 'Après l avènement de la société de l information et la digitalisation de pans entiers d activités de notre société, la révolution de l IA est en marche. Cette (r)évolution s accompagne d une médiatisation tous azimuts, oscillant entre fantasmes dystopiques et électrochocs nécessaires d une opinion publique souvent perdue au sein de ce maelström. Une chose est sûre, l IA occupe les pensées et vient bouleverser notre droit.', '2021-08-18', 2, 9782409031342, 'IA-9782409031342-0-front.jpg'),
(-29,'Le réseau avec microsoft azure - déployez, hybridez et sécurisez vos réseaux dans le cloud', 'Avec l’avènement des technologies cloud, les réseaux d’entreprises doivent inévitablement faire face à de nouveaux enjeux d’hybridation, de sécurisation et d’optimisation. Ce livre s’adresse à toute personne (expert technique, architecte, consultant, ingénieur réseau...) qui souhaite appréhender techniquement l’ensemble des services réseau proposés dans le cloud Azure en considérant à la fois le coût et les enjeux de sécurité dans le choix d’une architecture.', '2022-03-16', 2, 9782409034121, 'ms_azure-9782409034121-0-front.jpg'),
(-30,'Les réseaux informatiques - Guide pratique pour l administration, la sécurité et la supervision', 'Ce livre sur les réseaux informatiques s adresse aussi bien aux administrateurs réseau, techniciens ou ingénieurs en charge de la conception, de l administration, de la sécurité et de la mise en place de solutions de supervision d un réseau, qu aux étudiants souhaitant disposer de connaissances théoriques et techniques nécessaires pour exercer le métier d administrateur réseau au sens large.', '2023-01-11', 2, 9782409038389, 'Default.jpeg'),
(-31,'Linux - Principes de base de l utilisation du système', 'Ce livre sur GNU/Linux s’adresse à tout informaticien désireux de maîtriser les principes de base de ce système d’exploitation ou d’organiser et consolider des connaissances acquises sur le terrain.', '2022-11-16', 2, 9782409037764, 'linux-9782409037764-0-front.jpg'),
(-32,'Gestion de projet agile - De la définition du besoin à la livraison d un produit de qualité', 'Cet ouvrage est destiné à toute personne impliquée dans un projet agile et s adresse particulièrement aux responsables de produit et aux analystes qui sont au contact avec les utilisateurs et en charge de la définition d un produit. Ils trouveront dans ce livre les informations utiles pour maîtriser les techniques fondamentales pour recueillir le besoin et le formuler correctement.', '2021-12-08', 2, 9782409033391, 'gpa-9782409033391-0-front.jpg');

--
-- Structure de la table `auteur`
--
DROP TABLE IF EXISTS auteur cascade;
CREATE TABLE IF NOT EXISTS auteur(
   idAuteur  SERIAL PRIMARY KEY,
   nomAuteur VARCHAR(50) Not Null,
   prenomAuteur VARCHAR(50) Not Null
);
--
-- Jeux de données de la table 'auteur'
--
INSERT INTO auteur (idAuteur, nomAuteur, prenomAuteur) VALUES
(-1, 'kohei', 'horikoshi'),
(-2, 'mitsuhiro', 'mizuno'),
(-3, 'kentaro', 'miura');


--
-- Structure de la table `motCle`
--
DROP TABLE IF EXISTS motCle cascade;
CREATE TABLE IF NOT EXISTS motCle(
   idMotCle  SERIAL PRIMARY KEY,
   motCle VARCHAR(150) Not Null
);
--
-- Jeux de données de la table 'motCle'
--
INSERT INTO motCle (idMotCle, motCle) VALUES
(-1, 'shojo'),
(-2, 'shonen'),
(-3, 'seinen');

--
-- Structure de la table `formation`
--
DROP TABLE IF EXISTS formation cascade;
CREATE TABLE IF NOT EXISTS formation(
   idFormation  SERIAL PRIMARY KEY,
    libelleFormation VARCHAR(50) Not Null

);
--
-- Jeux de données de la table 'formation'
--
INSERT INTO formation (idFormation, libelleFormation) VALUES
(-1, '3csi'),
(-2, 'btsSio1'),
(-3, 'btsSio2');



--
-- Structure de la table `promotion`
--
DROP TABLE IF EXISTS promotion cascade;
CREATE TABLE IF NOT EXISTS promotion(
   idPromotion  SERIAL PRIMARY KEY,
   nomPromotion VARCHAR(50) Not Null,
   debutFormation DATE Not Null,
   finFormation DATE Not Null,
   idUtilisateur INT REFERENCES formation(idFormation),
   CONSTRAINT CheckValidDate CHECK(debutFormation < finFormation)
);
--
-- Jeux de données de la table 'promotion'
--
INSERT INTO promotion (idPromotion, nomPromotion, debutFormation, finFormation) VALUES
(-1, 'oiseau','2023-12-12', To_Date('2024-12-12', 'YYYY/MM/DD')),
(-2, 'bureau', '2023-12-12', '2025-12-12'),
(-3, 'table', '2023-12-12', '2025-12-12');



--
-- Structure de la table `utilisateur`
--
DROP TABLE IF EXISTS utilisateur cascade;
CREATE TABLE IF NOT EXISTS utilisateur(
   idUtilisateur  SERIAL PRIMARY KEY,
   nomUtilisateur VARCHAR(50) NOT NULL ,
   prenomUtilisateur VARCHAR(50) NOT NULL,
   passwordUtilisateur VARCHAR(500) NOT NULL,
   emailUtilisateur VARCHAR(500) NOT NULL,
   compteActif BOOLEAN NOT NULL DEFAULT true,
   idRole INT NOT NULL,
   FOREIGN KEY(idRole) REFERENCES role(idRole),
   CONSTRAINT uniqueEmail UNIQUE(emailUtilisateur)

);
--
-- Jeux de données de la table 'utilisateur'
--
INSERT INTO utilisateur (idUtilisateur, nomUtilisateur, prenomUtilisateur, emailUtilisateur, passwordUtilisateur, compteActif, idRole) VALUES
(-1, 'garciaGestionnaire', 'victorio', 'victoriogdlp@gmail.com', 'root', true,  -1),
(-2, 'brunFormateur', 'amelie', 'amelie@gmail.com', 'root', false,  -2),
(-3, 'SANTYKHAMEtudiant', 'celia', 'celiaSANTYKHAM@gmail.com', 'root', false,  -3),
(-4, 'LectureSeule', 'cyprien', 'cyprien@gmail.com', 'root', false,  -4);



--
-- Structure de la table `transaction`
--
DROP TABLE IF EXISTS transaction cascade;
CREATE TABLE IF NOT EXISTS transaction(
   idTransaction  SERIAL PRIMARY KEY,
   nbLivreAjoute INT NOT NULL,
   nbLivreEnlever INT NOT NULL,
   idUtilisateur INT NOT NULL,
   IdLivre INT NOT NULL,
   FOREIGN KEY(idUtilisateur) REFERENCES utilisateur(idUtilisateur),
   FOREIGN KEY(IdLivre) REFERENCES livre(IdLivre)
);
--
-- Jeux de données de la table 'transaction'
--
INSERT INTO transaction (idTransaction, nbLivreAjoute, nbLivreEnlever, idUtilisateur, IdLivre)
VALUES
(-1, -3, -0, -1, -1),
(-2, -1, -1, -2, -2),
(-3, -1, -5, -3, -3);



--
-- Structure de la table `modules`
--
DROP TABLE IF EXISTS modules cascade;
CREATE TABLE IF NOT EXISTS modules(
   idModules SERIAL PRIMARY KEY,
   nomModules VARCHAR(50) Not Null
);
--
-- Jeux de données de la table 'modules'
--
INSERT INTO modules (idModules, nomModules)
VALUES
(default, 'bdd'),
(default, 'php'),
(default, 'reseauxlocaux');




DROP TABLE IF EXISTS promotionUtilisateur cascade;
CREATE TABLE IF NOT EXISTS promotionUtilisateur(
   idUtilisateur INT,
   idPromotion INT,
   PRIMARY KEY(idUtilisateur, idPromotion),
   FOREIGN KEY(idUtilisateur) REFERENCES utilisateur(idUtilisateur),
   FOREIGN KEY(idPromotion) REFERENCES promotion(idPromotion)
);

DROP TABLE IF EXISTS livreAuteur cascade;
CREATE TABLE IF NOT EXISTS livreAuteur(
   PRIMARY KEY(IdLivre, idAuteur),
   IdLivre INT REFERENCES livre(IdLivre),
   idAuteur INT REFERENCES auteur(idAuteur)
);


DROP TABLE IF EXISTS livreEditeur cascade;
CREATE TABLE IF NOT EXISTS livreEditeur(
   PRIMARY KEY(idEditeur, IdLivre),
   idEditeur INT REFERENCES editeur(idEditeur),
   IdLivre INT REFERENCES livre(IdLivre)
);


DROP TABLE IF EXISTS livreUtilisateur cascade;
CREATE TABLE IF NOT EXISTS livreUtilisateur(
   dateReservation DATE NOT NULL,
   dateRendu DATE,
   nbExemplaire INT,
   dateEmprunt DATE,
   etatRes VARCHAR, --  En-attente - En-Cours - Terminer
   archiver BOOLEAN DEFAULT false,
   PRIMARY KEY(idUtilisateur, IdLivre, dateReservation),
   idUtilisateur INT REFERENCES utilisateur(idUtilisateur),
   IdLivre INT REFERENCES livre(IdLivre),
   CONSTRAINT dateVerif CHECK (dateReservation  <=  dateRendu),
   CONSTRAINT VerifNbExemplaire CHECK (nbExemplaire  > 0)   
);
INSERT INTO livreUtilisateur (dateReservation, dateRendu, nbExemplaire, dateEmprunt, etatRes, archiver, idUtilisateur, IdLivre)
VALUES
('2024-12-12', '2025-12-12', 5, '2024-12-12', 'En-attente', false, -1, -1),
('2024-12-12', '2025-12-12', 1, '2024-12-12', 'En-Cours', false, -2, -2),
('2024-12-12', '2025-12-12', 1, '2024-12-12', 'Terminer', false, -3, -3);


DROP TABLE IF EXISTS motCleLivre cascade;
CREATE TABLE IF NOT EXISTS motCleLivre(
   PRIMARY KEY(IdLivre, idMotCle),
   IdLivre INT REFERENCES livre(IdLivre),
   idMotCle INT REFERENCES motCle(idMotCle)
);
INSERT INTO motCleLivre (IdLivre, idMotCle)
VALUES
(-1, -1),
(-2, -2),
(-3, -3);


DROP TABLE IF EXISTS modulesUser cascade;
CREATE TABLE IF NOT EXISTS modulesUser(
   PRIMARY KEY(idUtilisateur, idModules),
   IdUtilisateur INT REFERENCES utilisateur(IdUtilisateur),
   idModules INT REFERENCES modules(idModules)
);


--regarder si le role est bien le role "formateur"
CREATE OR REPLACE FUNCTION triggerFonctionCheckUserIsFormateur()
   RETURNS TRIGGER
AS $$
DECLARE IdRoleUser integer = (select idRole from utilisateur where idUtilisateur = new.idUtilisateur);
BEGIN
  IF new.NbExemplaire <= 1   THEN
  --Si Nb Exemplaire <= 1 Good
        return new;
    ELSif IdRoleUser = -2 then
        return new;
    else 
        raise exception 'Trop de livres pour le role de l''emprunteur';

    END IF;
    
END;
$$ LANGUAGE plpgsql;

Create OR REPLACE Trigger triggerTeam4
    before insert or update on LivreUtilisateur
    for each row 
    execute function triggerFonctionCheckUserIsFormateur();

-- INSERT INTO livreUtilisateur (dateReservation, dateRendu, nbExemplaire, dateEmprunt, archiver, idUtilisateur, IdLivre)
-- VALUES
-- ('2024-07-06', '2025-12-12', 1 , '2024-12-12', false, -2, -1)

--regarder si le role est bien le role "formateur"
CREATE OR REPLACE FUNCTION triggerFonctionCheckUserIsGestionnaire()
   RETURNS TRIGGER
AS $$
DECLARE IdRoleUser integer = (select idRole from utilisateur where idUtilisateur = new.idUtilisateur);
BEGIN
  
  IF IdRoleUser = -1   THEN
        return new;
    else 
        raise exception 'Seul le gestionnaire peut créer des transactions ';
    END IF;
    
END;
$$ LANGUAGE plpgsql;






