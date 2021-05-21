select distinct tblOpenChampDivGenOverallPoints.RunnerID AS RunnerID,
tblRunners.RunnerFirstName AS RunnerFirstName,
tblRunners.RunnerSurname AS RunnerSurname,
tblRunners.RunnerSex AS RunnerSex,
tblMembershipArchive.RunnerDiv AS RunnerDiv,
tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints AS OpenChampDivGenOverallPoints,
tblOpenChampDivGenOverallPoints.ChampionshipID AS ChampionshipID,
tblOpenChampDivGenOverallPoints.ChampYear AS ChampYear
FROM ((tblOpenChampDivGenOverallPoints
       JOIN tblRunners on((tblOpenChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID)))
      JOIN tblMembershipArchive on((tblOpenChampDivGenOverallPoints.RunnerID = tblMembershipArchive.RunnerID)))
WHERE (tblOpenChampDivGenOverallPoints.ChampYear > 2018
       AND tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints > 0)
ORDER BY tblRunners.RunnerSex desc,
tblMembershipArchive.RunnerDiv,
tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints desc