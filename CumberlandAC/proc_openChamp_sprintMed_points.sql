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
 
IF record_exists IS NOT NULL THEN UPDATE tblOpenChampOverall SET OpenChampCatSprintMedPoints = total_points WHERE RunnerID = runner_id AND ChampionshipID = 1;
ELSE INSERT INTO tblOpenChampOverall (RunnerID,OpenChampCatSprintMedPoints,ChampionshipID) VALUES (runner_id,total_points,1);
END IF;
END