BEGIN
	DECLARE record_exists_mf_id
		,record_exists_joint_id
		,total_points_mf
		,total_points_joint
		,champ_year
		,runner_div INT;
	DECLARE runner_sex VARCHAR(5);

	SET champ_year = (
			SELECT ChampYear
			FROM tblRaces
			WHERE RaceID = race_id
			);
	SET record_exists_mf_id = (
			SELECT ShortChampDivGenOverallPointsID
			FROM tblShortChampDivGenOverallPoints
			WHERE RunnerID = runner_id
				AND (
					RunnerSex = 'M'
					OR RunnerSex = 'F'
					)
				AND ChampYear = champ_year
			);
	SET runner_sex = (
			SELECT RunnerSex
			FROM tblRunners
			WHERE RunnerID = runner_id
			);
	SET runner_div = (
			SELECT RunnerDiv
			FROM tblRunners
			WHERE RunnerID = runner_id
			);
	SET total_points_mf = (
			SELECT SUM(ShortChampDivGenRacePoints)
			FROM (
				SELECT ShortChampDivGenRacePoints
				FROM tblShortChampDivGenRacePoints
				WHERE RunnerID = runner_id
					AND (
						RunnerSex = 'M'
						OR RunnerSex = 'F'
						)
					AND RaceID IN (
						SELECT RaceID
						FROM tblRaces
						WHERE RaceCode IN (
								8
								,9
								)
							AND ChampYear = champ_year
						)
				ORDER BY ShortChampDivGenRacePoints DESC LIMIT 6
				) overall
			);

	IF record_exists_mf_id IS NOT NULL THEN
		UPDATE tblShortChampDivGenOverallPoints
		SET ShortChampDivGenOverallPoints = total_points_mf
			,RunnerSex = runner_sex
			,RunnerDiv = runner_div
			,ChampYear = champ_year
		WHERE ShortChampDivGenOverallPointsID = record_exists_mf_id;
	ELSE
		INSERT INTO tblShortChampDivGenOverallPoints (
			RunnerID
			,RunnerSex
			,RunnerDiv
			,ShortChampDivGenOverallPoints
			,ChampionshipID
			,ChampYear
			)
		VALUES (
			runner_id
			,runner_sex
			,runner_div
			,total_points_mf
			,2
			,champ_year
			);
	END IF;
END