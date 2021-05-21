BEGIN
DECLARE race_points, record_exists_ladies_id INT;

SET race_points = (101-rank);

SET record_exists_ladies_ID = (SELECT OpenChampLadiesRacePointsID FROM tblOpenChampLadiesRacePoints WHERE RunnerID = runner_id AND RaceID = race_id);


IF record_exists_ladies_ID IS NOT NULL THEN
    UPDATE tblOpenChampLadiesRacePoints
    SET LadiesRacePoints = race_points
    WHERE OpenChampLadiesRacePointsID = record_exists_ladies_ID;
ELSE
    INSERT INTO tblOpenChampLadiesRacePoints (RaceID,LadiesRacePoints,RunnerID)
    VALUES (race_id,race_points,runner_id);
END IF;

END