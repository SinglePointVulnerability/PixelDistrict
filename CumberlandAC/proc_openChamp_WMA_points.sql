BEGIN
DECLARE record_exists_WMA_id, race_points INT;
DECLARE runner_sex VARCHAR(5);

SET race_points = (101-rank);
SET runner_sex = (SELECT RunnerSex FROM tblRunners WHERE RunnerID=runner_id);

SET record_exists_WMA_id = (SELECT OpenChampWMAGenRacePointsID FROM tblOpenChampWMARacePoints WHERE RunnerID = runner_id AND (RunnerSex = 'M' OR RunnerSex = 'F') AND RaceID = race_id);

/*IF EXISTS (SELECT * FROM tblOpenChampWMARacePoints WHERE RaceID = race_id AND RunnerID = runner_id) THEN UPDATE tblOpenChampWMARacePoints SET WMARacePoints = @race_points WHERE RunnerID = runner_id AND RaceID = race_id;*/
IF record_exists_WMA_id IS NOT NULL THEN
UPDATE tblOpenChampWMARacePoints SET WMARacePoints = race_points WHERE OpenChampWMAGenRacePointsID = record_exists_WMA_id;
ELSE
INSERT INTO tblOpenChampWMARacePoints (RaceID,WMARacePoints,RunnerID,RunnerSex) VALUES (race_id, race_points, runner_id, runner_sex);
END IF;

END