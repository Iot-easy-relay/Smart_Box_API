/*TABLE Casier*/
CREATE TABLE `Casier` (
  `idCasier` int(20) NOT NULL,
  `code_Commune` int(4) NOT NULL, 
  `adresse` varchar(30) NOT NULL,
   PRIMARY KEY (`idCasier`),
/*index sur le code_Commune*/
 INDEX `index_code_Commune` (`code_Commune`)
) ENGINE = InnoDB DEFAULT CHARSET=latin1;


/*TABLE Box*/
CREATE TABLE `Box` (
  `idBox` int(11) NOT NULL,
  `idCasier` int(11) NOT NULL,
  `etatBox` varchar(20) NOT NULL,
  `longueurBox` float(11) NOT NULL,
  `largeurBox` float(11) NOT NULL,
  `hauteurBox` float(11) NOT NULL,
  PRIMARY KEY (`idBox`,`idCasier`),
  FOREIGN KEY (`idCasier`) REFERENCES `Casier` (`idCasier`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*--TABLE Box_Contient_Colis*/
CREATE TABLE `Box_Contient_Colis` (
  `idActeur` int(11) NOT NULL,
  `idBox` int(11) NOT NULL,
  `idCasier` int(11) NOT NULL,
  `idColis` int(11) NOT NULL,
  `typeOperation` varchar(15), /*depot ou retrait*/
  `dateOperation` Date,
  PRIMARY KEY (`idActeur`,`idBox`,`idCasier`,`idColis`,`typeOperation`),
  FOREIGN KEY (`idBox`) REFERENCES `Box` (`idBox`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`idCasier`) REFERENCES `Casier` (`idCasier`) ON DELETE CASCADE ON UPDATE CASCADE,
  /*index sur le idColis`*/
 INDEX `index_idColis` (`idColis`),
/*index sur le idActeur`*/
 INDEX `index_idActeur`  (`idActeur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
