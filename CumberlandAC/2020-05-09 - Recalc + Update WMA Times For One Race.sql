--This script must be copied and executed in one go in phpMyAdmin
-- --The temporary table only exists in one session and cannot be accessed unless it is ran this way
CREATE TEMPORARY TABLE tempTblWMA (
	ID INT auto_increment PRIMARY KEY
	,RunnerID INT
	,RunnerFirstName VARCHAR(32)
	,RunnerSurname VARCHAR(32)
	,RunnerSex VARCHAR(1)
	,RaceID INT
	,AgeAtRaceStart INT
	,WMAFactor DECIMAL(6, 5)
	,RaceTime TIME
	,WMAAdjustedTime TIME
	);

INSERT INTO tempTblWMA (
	RunnerID
	,RunnerFirstName
	,RunnerSurname
	,RunnerSex
	,RaceID
	,AgeAtRaceStart
	,WMAFactor
	,RaceTime
	,WMAAdjustedTime
	)
SELECT tblRunners.RunnerID
	,tblRunners.RunnerFirstName
	,tblRunners.RunnerSurname
	,tblRunners.RunnerSex
	,tblRaceTimes.RaceID
	,FLOOR(DATEDIFF((
				SELECT tblraces.RaceDate
				FROM tblraces
				WHERE RaceID = 124
				), RunnerDOB) / 365.25) AS AgeAtRaceStart
	,tblWMA.WMAFactor
	,tblRaceTimes.RaceTime
	,SEC_TO_TIME(tblWMA.WMAFactor * TIME_TO_SEC(tblRaceTimes.RaceTime)) AS WMAAdjustedTime
FROM tblRunners
LEFT JOIN tblWMA ON (
		FLOOR(DATEDIFF((
					SELECT tblraces.RaceDate
					FROM tblraces
					WHERE RaceID = 124
					), RunnerDOB) / 365.25)
		) = tblWMA.WMAAge
	AND tblRunners.RunnerSex = tblWMA.WMASex
LEFT JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID
	AND tblRaceTimes.RaceID = 124
WHERE tblRunners.RunnerID IN (
		SELECT tblWMARaceTimes.RunnerID
		FROM tblWMARaceTimes
		WHERE RaceID = 124
		)
	AND tblWMA.WMADistance = (
		SELECT (tblRaces.RaceDist / 1000) AS RaceDistKmToM
		FROM tblRaces
		WHERE RaceID = 124
		);

UPDATE tblWMARaceTimes AS dest
INNER JOIN tempTblWMA AS source ON dest.RunnerID = source.RunnerID
	AND dest.RaceID = source.RaceID

SET dest.WMARaceTime = source.WMAAdjustedTime
	,dest.WMARunnerLevel = source.WMAFactor;