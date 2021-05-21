SELECT distinct `cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`.`RunnerID` AS `RunnerID`,
`cacad-i88-u-107153`.`tblrunners`.`RunnerFirstName` AS `RunnerFirstName`,
`cacad-i88-u-107153`.`tblrunners`.`RunnerSurname` AS `RunnerSurname`,
`cacad-i88-u-107153`.`tblrunners`.`RunnerSex` AS `RunnerSex`,
`cacad-i88-u-107153`.`tblrunners`.`RunnerDiv` AS `RunnerDiv`,
`cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`.`OpenChampDivGenOverallPoints` AS `OpenChampDivGenOverallPoints`,
`cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`.`ChampionshipID` AS `ChampionshipID`,
`cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`.`ChampYear` AS `ChampYear`
FROM (`cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`
       JOIN `cacad-i88-u-107153`.`tblrunners` ON ((`cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`.`RunnerID` = `cacad-i88-u-107153`.`tblrunners`.`RunnerID`)))
WHERE ((`cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`.`ChampYear` > 2018) AND (`cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`.`OpenChampDivGenOverallPoints` > 0))
ORDER BY `cacad-i88-u-107153`.`tblrunners`.`RunnerSex` desc,`cacad-i88-u-107153`.`tblrunners`.`RunnerDiv`,`cacad-i88-u-107153`.`tblopenchampdivgenoverallpoints`.`OpenChampDivGenOverallPoints` desc

/*UNLINK ChampYear from tblChampionships queries
 - no need for a championship year in this table; it only confuses queries like the one above.
 - instead, add a 'ChampYear' column to the OverallPoints table
    - this will allow the championship IDs to be re-used since they won't be changing year on year
    - use the ChampYear reference in the Overall Points table
    
    
    1/ add a new column to tblOpenChampDivGenOverallPoints table (done)
    2/ update any references to tblOpenChampDivGenOverallPoints in formPost.php so that when the table is updated, the ChampYear column is also added
    3/ same as above, but for any stored procedures sitting on the server
    4/ once all of the instances referring to the champYear in tblChampionships have been removed, delete the column from that table 
 */
 
 
 
 
/* 2/ proc_openChamp_overall_points - REMOVE REFERENCES TO THIS OLD PROCEDURE */
 BEGIN
DECLARE record_exists, total_points, champ_year INT;

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists = (SELECT ChampionshipID FROM tblOpenChampOverall WHERE RunnerID = runner_id AND ChampionshipID = 1);

SET total_points = (SELECT SUM(OpenChampCatLongPoints+OpenChampCatMidPoints+OpenChampCatSprintPoints) AS OpenChampTotal FROM tblOpenChampOverall WHERE RunnerID = runner_id AND OpenChampID IN (SELECT OpenChampID FROM tblChampionships WHERE ChampionshipName = 'Open Championship' AND ChampYear = champ_year));
 
IF record_exists IS NOT NULL THEN UPDATE tblOpenChampOverall SET OpenChampOverallPoints = total_points WHERE RunnerID = runner_id AND ChampionshipID = 1;
ELSE INSERT INTO tblOpenChampOverall (RunnerID,OpenChampOverallPoints,ChampionshipID) VALUES (runner_id,total_points,1);
END IF;

END




/* 2/ proc_openChamp_sprint_points - REMOVE REFERENCES TO THIS OLD PROCEDURE */
BEGIN
DECLARE record_exists, total_points, champ_year INT;

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists = (SELECT ChampionshipID FROM tblOpenChampOverall WHERE RunnerID = runner_id AND ChampionshipID = 1);

SET total_points = (SELECT SUM(OpenChampRacePoints) FROM
(SELECT OpenChampRacePoints
 FROM tblOpenChampRacePoints
 WHERE RunnerID = runner_id AND RaceID IN
 (Select RaceID
  FROM tblRaces
  WHERE RaceCode IN (1,9) AND ChampYear = champ_year)
 ORDER BY OpenChampRacePoints DESC LIMIT 2) overall);
 
IF record_exists IS NOT NULL THEN UPDATE tblOpenChampOverall SET OpenChampCatSprintPoints = total_points WHERE RunnerID = runner_id AND ChampionshipID = 1;
ELSE INSERT INTO tblOpenChampOverall (RunnerID,OpenChampCatSprintPoints,ChampionshipID) VALUES (runner_id,total_points,1);
END IF;
END