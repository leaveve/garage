### Premier etape, making entities  30/09/2026 
## USER 
- symfony console make:user
->The name of the security user class (e.g. User) [User]:
 > 

 Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
 > 

 Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
 > 

 Will this app need to hash/check user passwords? Choose No if passwords are not needed or will be checked/hashed by some other system (e.g. a single sign-on server).

 Does this app need to hash/check user passwords? (yes/no) [yes]:
 > 

## ajouter les champs a user 
- symfony console make:entity User
->
evokitty@MacBook-Air-de-evo garage % symfony console make:entity User
 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > nom

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 100

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > prenom

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 100

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > telephone

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 20

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > dateNaissance

 Field type (enter ? to see all types) [string]:
 > date

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > adresse

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > codePostal

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 10

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > ville

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 100

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > datePermis

 Field type (enter ? to see all types) [string]:
 > date

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > dateInscription

 Field type (enter ? to see all types) [string]:
 > datetime_immutable

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > actif

 Field type (enter ? to see all types) [string]:
 > boolean

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
    **je me suois trompé en créant l'entité user j'ai msi certains champs en non nullable alors qu'il devrait l'etre
    donc j'ai du corriger a la main dans user.php en ajotant nullable : true et un ? dans les setters**

## les entités simples.   ## 14/10/2016
- symfony console make:entity Marque
-> evokitty@MacBook-Air-de-evo garage % symfony console make:entity Marque
 created: src/Entity/Marque.php
 created: src/Repository/MarqueRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > libelle

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 100

 Can this field be null in the database (nullable) (yes/no) [no]:
 > no

 updated: src/Entity/Marque.php

 **pareil pour TypeVoiture , Transmision et Carburant**


 
## l’entité Modele
 evokitty@macbook-air-de-evo1 garage % symfony console make:entity Modele
 created: src/Entity/Modele.php
 created: src/Repository/ModeleRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > libelle

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 100

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Modele.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > marque

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Marque

What type of relationship is this?
 ------------ --------------------------------------------------------------------- 
  Type         Description                                                          
 ------------ --------------------------------------------------------------------- 
  ManyToOne    Each Modele relates to (has) one Marque.                             
               Each Marque can relate to (can have) many Modele objects.            
                                                                                    
  OneToMany    Each Modele can relate to (can have) many Marque objects.            
               Each Marque relates to (has) one Modele.                             
                                                                                    
  ManyToMany   Each Modele can relate to (can have) many Marque objects.            
               Each Marque can also relate to (can also have) many Modele objects.  
                                                                                    
  OneToOne     Each Modele relates to (has) exactly one Marque.                     
               Each Marque also relates to (has) exactly one Modele.                
 ------------ --------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the Modele.marque property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Marque so that you can access/update Modele objects from it - e.g. $marque->getModeles()? (yes/no) [yes]:
 > 

 A new property will also be added to the Marque class so that you can access the related Modele objects from it.

 New field name inside Marque [modeles]:
 > 

 Do you want to activate orphanRemoval on your relationship?
 A Modele is "orphaned" when it is removed from its related Marque.
 e.g. $marque->removeModele($modele)
 
 NOTE: If a Modele may *change* from one Marque to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Modele objects (orphanRemoval)? (yes/no) [no]:
 > 

 updated: src/Entity/Modele.php
 updated: src/Entity/Marque.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > typeVoiture

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > TypeVoiture

What type of relationship is this?
 ------------ -------------------------------------------------------------------------- 
  Type         Description                                                               
 ------------ -------------------------------------------------------------------------- 
  ManyToOne    Each Modele relates to (has) one TypeVoiture.                             
               Each TypeVoiture can relate to (can have) many Modele objects.            
                                                                                         
  OneToMany    Each Modele can relate to (can have) many TypeVoiture objects.            
               Each TypeVoiture relates to (has) one Modele.                             
                                                                                         
  ManyToMany   Each Modele can relate to (can have) many TypeVoiture objects.            
               Each TypeVoiture can also relate to (can also have) many Modele objects.  
                                                                                         
  OneToOne     Each Modele relates to (has) exactly one TypeVoiture.                     
               Each TypeVoiture also relates to (has) exactly one Modele.                
 ------------ -------------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the Modele.typeVoiture property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to TypeVoiture so that you can access/update Modele objects from it - e.g. $typeVoiture->getModeles()? (yes/no) [yes]:
 >   

 A new property will also be added to the TypeVoiture class so that you can access the related Modele objects from it.

 New field name inside TypeVoiture [modeles]:
 > 

 Do you want to activate orphanRemoval on your relationship?
 A Modele is "orphaned" when it is removed from its related TypeVoiture.
 e.g. $typeVoiture->removeModele($modele)
 
 NOTE: If a Modele may *change* from one TypeVoiture to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Modele objects (orphanRemoval)? (yes/no) [no]:
 > 

 updated: src/Entity/Modele.php
 updated: src/Entity/TypeVoiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 

## l’entité Voiture

evokitty@macbook-air-de-evo1 garage % symfony console make:entity Voiture
 created: src/Entity/Voiture.php
 created: src/Repository/VoitureRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > annee

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > kilometrage

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > puissanceCh

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > couleur

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 50

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > couleurHex

 Field type (enter ? to see all types) [string]:
 > string

 Field length [255]:
 > 7

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > prixVente

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > prixLocationJour

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > caution

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > description

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > photo

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > aVendre

 Field type (enter ? to see all types) [string]:
 > boolean

 Can this field be null in the database (nullable) (yes/no) [no]:
 > no

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > aLouer

 Field type (enter ? to see all types) [string]:
 > boolean

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > statut

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 20

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > modele

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Modele

What type of relationship is this?
 ------------ ---------------------------------------------------------------------- 
  Type         Description                                                           
 ------------ ---------------------------------------------------------------------- 
  ManyToOne    Each Voiture relates to (has) one Modele.                             
               Each Modele can relate to (can have) many Voiture objects.            
                                                                                     
  OneToMany    Each Voiture can relate to (can have) many Modele objects.            
               Each Modele relates to (has) one Voiture.                             
                                                                                     
  ManyToMany   Each Voiture can relate to (can have) many Modele objects.            
               Each Modele can also relate to (can also have) many Voiture objects.  
                                                                                     
  OneToOne     Each Voiture relates to (has) exactly one Modele.                     
               Each Modele also relates to (has) exactly one Voiture.                
 ------------ ---------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the Voiture.modele property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Modele so that you can access/update Voiture objects from it - e.g. $modele->getVoitures()? (yes/no) [yes]:
 > 

 A new property will also be added to the Modele class so that you can access the related Voiture objects from it.

 New field name inside Modele [voitures]:
 > 

 Do you want to activate orphanRemoval on your relationship?
 A Voiture is "orphaned" when it is removed from its related Modele.
 e.g. $modele->removeVoiture($voiture)
 
 NOTE: If a Voiture may *change* from one Modele to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Voiture objects (orphanRemoval)? (yes/no) [no]:
 > no

 updated: src/Entity/Voiture.php
 updated: src/Entity/Modele.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > transmission

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Transmission

What type of relationship is this?
 ------------ ---------------------------------------------------------------------------- 
  Type         Description                                                                 
 ------------ ---------------------------------------------------------------------------- 
  ManyToOne    Each Voiture relates to (has) one Transmission.                             
               Each Transmission can relate to (can have) many Voiture objects.            
                                                                                           
  OneToMany    Each Voiture can relate to (can have) many Transmission objects.            
               Each Transmission relates to (has) one Voiture.                             
                                                                                           
  ManyToMany   Each Voiture can relate to (can have) many Transmission objects.            
               Each Transmission can also relate to (can also have) many Voiture objects.  
                                                                                           
  OneToOne     Each Voiture relates to (has) exactly one Transmission.                     
               Each Transmission also relates to (has) exactly one Voiture.                
 ------------ ---------------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the Voiture.transmission property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Transmission so that you can access/update Voiture objects from it - e.g. $transmission->getVoitures()? (yes/no) [yes]:
 > yes

 A new property will also be added to the Transmission class so that you can access the related Voiture objects from it.

 New field name inside Transmission [voitures]:
 > 

 Do you want to activate orphanRemoval on your relationship?
 A Voiture is "orphaned" when it is removed from its related Transmission.
 e.g. $transmission->removeVoiture($voiture)
 
 NOTE: If a Voiture may *change* from one Transmission to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Voiture objects (orphanRemoval)? (yes/no) [no]:
 > no

 updated: src/Entity/Voiture.php
 updated: src/Entity/Transmission.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > carburant

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Carburant

What type of relationship is this?
 ------------ ------------------------------------------------------------------------- 
  Type         Description                                                              
 ------------ ------------------------------------------------------------------------- 
  ManyToOne    Each Voiture relates to (has) one Carburant.                             
               Each Carburant can relate to (can have) many Voiture objects.            
                                                                                        
  OneToMany    Each Voiture can relate to (can have) many Carburant objects.            
               Each Carburant relates to (has) one Voiture.                             
                                                                                        
  ManyToMany   Each Voiture can relate to (can have) many Carburant objects.            
               Each Carburant can also relate to (can also have) many Voiture objects.  
                                                                                        
  OneToOne     Each Voiture relates to (has) exactly one Carburant.                     
               Each Carburant also relates to (has) exactly one Voiture.                
 ------------ ------------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the Voiture.carburant property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Carburant so that you can access/update Voiture objects from it - e.g. $carburant->getVoitures()? (yes/no) [yes]:
 > 

 A new property will also be added to the Carburant class so that you can access the related Voiture objects from it.

 New field name inside Carburant [voitures]:
 > 

 Do you want to activate orphanRemoval on your relationship?
 A Voiture is "orphaned" when it is removed from its related Carburant.
 e.g. $carburant->removeVoiture($voiture)
 
 NOTE: If a Voiture may *change* from one Carburant to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Voiture objects (orphanRemoval)? (yes/no) [no]:
 > 

 updated: src/Entity/Voiture.php
 updated: src/Entity/Carburant.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 

## l’entité RendezVous
evokitty@macbook-air-de-evo1 garage % symfony console make:entity RendezVous
 created: src/Entity/RendezVous.php
 created: src/Repository/RendezVousRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > dateHeure

 Field type (enter ? to see all types) [string]:
 > datetime_immutable

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/RendezVous.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > motif

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 20

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/RendezVous.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > dateDebutLocation

 Field type (enter ? to see all types) [string]:
 > date_immutable

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/RendezVous.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > dateFinLocation

 Field type (enter ? to see all types) [string]:
 > date_immutable

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/RendezVous.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > message

 Field type (enter ? to see all types) [string]:
 > text

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/RendezVous.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > statut

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 20

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/RendezVous.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > dateCreation

 Field type (enter ? to see all types) [string]:
 > datetime_immutable

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/RendezVous.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > user


         
 [ERROR] Name "user" is a reserved word.
         

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > client

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > User

What type of relationship is this?
 ------------ ----------------------------------------------------------------------- 
  Type         Description                                                            
 ------------ ----------------------------------------------------------------------- 
  ManyToOne    Each RendezVous relates to (has) one User.                             
               Each User can relate to (can have) many RendezVous objects.            
                                                                                      
  OneToMany    Each RendezVous can relate to (can have) many User objects.            
               Each User relates to (has) one RendezVous.                             
                                                                                      
  ManyToMany   Each RendezVous can relate to (can have) many User objects.            
               Each User can also relate to (can also have) many RendezVous objects.  
                                                                                      
  OneToOne     Each RendezVous relates to (has) exactly one User.                     
               Each User also relates to (has) exactly one RendezVous.                
 ------------ ----------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the RendezVous.client property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to User so that you can access/update RendezVous objects from it - e.g. $user->getRendezVouses()? (yes/no) [yes]:
 > 

 A new property will also be added to the User class so that you can access the related RendezVous objects from it.

 New field name inside User [rendezVouses]:
 > 

 Do you want to activate orphanRemoval on your relationship?
 A RendezVous is "orphaned" when it is removed from its related User.
 e.g. $user->removeRendezVous($rendezVous)
 
 NOTE: If a RendezVous may *change* from one User to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\RendezVous objects (orphanRemoval)? (yes/no) [no]:
 > 

 updated: src/Entity/RendezVous.php
 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > voiture

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Voiture

What type of relationship is this?
 ------------ -------------------------------------------------------------------------- 
  Type         Description                                                               
 ------------ -------------------------------------------------------------------------- 
  ManyToOne    Each RendezVous relates to (has) one Voiture.                             
               Each Voiture can relate to (can have) many RendezVous objects.            
                                                                                         
  OneToMany    Each RendezVous can relate to (can have) many Voiture objects.            
               Each Voiture relates to (has) one RendezVous.                             
                                                                                         
  ManyToMany   Each RendezVous can relate to (can have) many Voiture objects.            
               Each Voiture can also relate to (can also have) many RendezVous objects.  
                                                                                         
  OneToOne     Each RendezVous relates to (has) exactly one Voiture.                     
               Each Voiture also relates to (has) exactly one RendezVous.                
 ------------ -------------------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the RendezVous.voiture property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Voiture so that you can access/update RendezVous objects from it - e.g. $voiture->getRendezVouses()? (yes/no) [yes]:
 > yes

 A new property will also be added to the Voiture class so that you can access the related RendezVous objects from it.

 New field name inside Voiture [rendezVouses]:
 > 

 Do you want to activate orphanRemoval on your relationship?
 A RendezVous is "orphaned" when it is removed from its related Voiture.
 e.g. $voiture->removeRendezVous($rendezVous)
 
 NOTE: If a RendezVous may *change* from one Voiture to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\RendezVous objects (orphanRemoval)? (yes/no) [no]:
 > 

 updated: src/Entity/RendezVous.php
 updated: src/Entity/Voiture.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with symfony console make:migration

## la migration

evokitty@macbook-air-de-evo1 garage % symfony console make:migration
 created: migrations/Version20261014154816.php

           
  Success! 
           

 Review the new migration then run it with symfony console doctrine:migrations:migrate
 See https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html
evokitty@macbook-air-de-evo1 garage % symfony console doctrine:migrations:migrate

 WARNING! You are about to execute a migration in database "garage" that could result in schema changes and data loss. Are you sure you wish to continue? (yes/no) [yes]:
 > 

[notice] Migrating up to DoctrineMigrations\Version20261014154816
[notice] finished in 48.3ms, used 24M memory, 1 migrations executed, 25 sql queries
      
 [OK] Successfully migrated to version: DoctrineMigrations\Version20261014154816



## Authentification : login, logout  15/1/2026


evokitty@macbook-air-de-evo1 garage % symfony console make:security:form-login

 Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
 > 

 Do you want to generate a '/logout' URL? (yes/no) [yes]:
 > 

 Do you want to generate PHPUnit tests? [Experimental] (yes/no) [no]:
 > 

 created: src/Controller/SecurityController.php
 created: templates/security/login.html.twig
 updated: config/packages/security.yaml

           
  Success! 


## la page d’accueil

evokitty@macbook-air-de-evo1 garage % symfony console make:controller Home

 Do you want to generate PHPUnit tests? [Experimental] (yes/no) [no]:
 > 

 created: src/Controller/HomeController.php
 created: templates/home/index.html.twig

           
  Success! 

##  le formulaire d’inscription 19/10/2026
evokitty@MacBook-Air-de-evo garage % symfony console make:registration-form
 Creating a registration form for App\Entity\User

 Do you want to add a #[UniqueEntity] validation attribute to your User class to make sure duplicate accounts aren't created? (yes/no) [yes]:
 > 

 Do you want to send an email to verify the user's email address after registration? (yes/no) [yes]:
 > no

 Do you want to automatically authenticate the user after registration? (yes/no) [yes]:
 > 

 Do you want to generate PHPUnit tests? [Experimental] (yes/no) [no]:
 > no

 updated: src/Entity/User.php
 created: src/Form/RegistrationFormType.php
 created: src/Controller/RegistrationController.php
 created: templates/registration/register.html.twig

           
  Success! 

  apres bien sur il faut compléter le formulaire avc nom prenom...

##  les rôles
ajout 
role_hierarchy:
        ROLE_STAFF: ROLE_USER
        ROLE_ADMIN: ROLE_STAFF 
dans securit.yaml

et 

access_control:
         - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/gestion, roles: ROLE_STAFF }
        - { path: ^/mon-compte, roles: ROLE_USER }

## le blocage des comptes
Quand le gérant mettra actif à false sur un compte, la personne ne doit plus pouvoir se connecter

Symfony a un outil prévu pour ça, le UserChecker
source;
https://symfony.com/doc/current/security/user_checkers.html

## installer les bundles des fixtures 20/10/2026

composer require --dev orm-fixtures
composer require --dev fakerphp/faker

## les données de ref
creation des fichier CarburantFixtures.php , MarqueFixtures.php , TransmissionFixtures , TypeVoitureFixtures 
puis 
symfony console doctrine:fixtures:load


