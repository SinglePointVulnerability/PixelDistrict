/* NOTE: for the current year, the RunnerDiv is populated using tblRunners NOT tblMembershipArchive */
SELECT DISTINCT tblOpenChampDivGenOverallPoints.RunnerID AS RunnerID,
tblRunners.RunnerFirstName AS RunnerFirstName,
tblRunners.RunnerSurname AS RunnerSurname,
tblRunners.RunnerSex AS RunnerSex,
tblRunners.RunnerDiv AS RunnerDiv,
tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints AS OpenChampDivGenOverallPoints,
tblOpenChampDivGenOverallPoints.ChampionshipID AS ChampionshipID,
tblOpenChampDivGenOverallPoints.ChampYear AS ChampYear
FROM (tblOpenChampDivGenOverallPoints 
      JOIN tblRunners on((tblOpenChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID)))
WHERE ((tblOpenChampDivGenOverallPoints.ChampYear = 2022
        AND tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints > 0))
ORDER BY tblRunners.RunnerSex desc,
tblRunners.RunnerDiv,
tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints desc