BEGIN
DECLARE record_exists_m_id, record_exists_f_id, total_points_m, total_points_f, champ_year, runner_div INT;
DECLARE runner_sex VARCHAR(5);

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists_m_id = (SELECT MTChallDivGenOverallPointsID FROM tblMTChallDivGenOverallPoints WHERE RunnerID = runner_id AND RunnerSex = 'M' AND ChampYear = champ_year);

SET record_exists_f_id = (SELECT MTChallDivGenOverallPointsID FROM tblMTChallDivGenOverallPoints WHERE RunnerID = runner_id AND RunnerSex = 'F' AND ChampYear = champ_year);

SET runner_sex = (SELECT RunnerSex FROM tblRunners WHERE RunnerID = runner_id);

SET runner_div = (SELECT RunnerDiv FROM tblRunners WHERE RunnerID = runner_id);

IF runner_sex = 'M' THEN
    SET total_points_m = (SELECT SUM(MTChallDivGenRacePoints) FROM
                          (SELECT MTChallDivGenRacePoints
    FROM tblMTChallDivGenRacePoints
    WHERE RunnerID = runner_id AND RunnerSex = 'M' AND RaceID IN
    (Select RaceID
    FROM tblRaces
    WHERE RaceCode IN (16) AND ChampYear = champ_year)
    ORDER BY MTChallDivGenRacePoints DESC LIMIT 5) overall);
    
    IF record_exists_m_id IS NOT NULL THEN
    UPDATE tblMTChallDivGenOverallPoints SET MTChallDivGenOverallPoints = total_points_m, RunnerSex = runner_sex, RunnerDiv = runner_div WHERE MTChallDivGenOverallPointsID = record_exists_m_id;
    ELSE
    INSERT INTO tblMTChallDivGenOverallPoints (RunnerID, RunnerSex, RunnerDiv, MTChallDivGenOverallPoints, ChampionshipID, ChampYear) VALUES (runner_id, runner_sex, runner_div, total_points_m, 3, champ_year);
    END IF;
ELSE
    SET total_points_f = (SELECT SUM(MTChallDivGenRacePoints) FROM
                          (SELECT MTChallDivGenRacePoints
    FROM tblMTChallDivGenRacePoints
    WHERE RunnerID = runner_id AND RunnerSex = 'F' AND RaceID IN
    (Select RaceID
    FROM tblRaces
    WHERE RaceCode IN (16) AND ChampYear = champ_year)
    ORDER BY MTChallDivGenRacePoints DESC LIMIT 5) overall2); 

    IF record_exists_f_id IS NOT NULL THEN
    UPDATE tblMTChallDivGenOverallPoints SET MTChallDivGenOverallPoints = total_points_f, RunnerSex = 'F', RunnerDiv = runner_div WHERE MTChallDivGenOverallPointsID = record_exists_f_id;
    ELSE
    INSERT INTO tblMTChallDivGenOverallPoints (RunnerID, RunnerSex, RunnerDiv, MTChallDivGenOverallPoints, ChampionshipID, ChampYear) VALUES (runner_id, 'F', runner_div, total_points_f, 3, champ_year);
    END IF;
END IF;
END