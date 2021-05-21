/* NOTE: for the current year, the RunnerDiv is populated using tblRunners NOT tblMembershipArchive */
SELECT distinct tblShortChampDivGenOverallPoints.RunnerID AS RunnerID,
tblRunners.RunnerFirstName AS RunnerFirstName,
tblRunners.RunnerSurname AS RunnerSurname,
tblRunners.RunnerSex AS RunnerSex,
tblRunners.RunnerDiv AS RunnerDiv,
tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints AS ShortChampDivGenOverallPoints,
tblShortChampDivGenOverallPoints.ChampionshipID AS ChampionshipID,
tblShortChampDivGenOverallPoints.ChampYear AS ChampYear
FROM (tblShortChampDivGenOverallPoints
       JOIN tblRunners on((tblShortChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID)))
WHERE ((tblShortChampDivGenOverallPoints.ChampYear = YEAR(CURDATE()))
       AND (tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints > 0))
       AND tblShortChampDivGenOverallPoints.RunnerSex IN ('M','F')
ORDER BY tblRunners.RunnerSex desc,
      tblRunners.RunnerDiv,
      tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints desc