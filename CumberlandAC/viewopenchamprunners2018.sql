SELECT DISTINCT tblOpenChampDivGenOverallPoints.RunnerID AS RunnerID,tblRunners.RunnerFirstName AS RunnerFirstName,tblRunners.RunnerSurname AS RunnerSurname,tblOpenChampDivGenOverallPoints.RunnerSex AS RunnerSex,tblMembershipArchive.RunnerDiv AS RunnerDiv,tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints AS OpenChampDivGenOverallPoints,tblOpenChampDivGenOverallPoints.ChampionshipID AS ChampionshipID,tblChampionships.ChampYear AS ChampYear
FROM (((tblOpenChampDivGenOverallPoints
        JOIN tblRunners on((tblOpenChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID)))
       JOIN tblChampionships on((tblOpenChampDivGenOverallPoints.ChampionshipID = tblChampionships.ChampionshipID)))
      JOIN tblMembershipArchive on((tblOpenChampDivGenOverallPoints.RunnerID = tblMembershipArchive.RunnerID)))
WHERE ((tblOpenChampDivGenOverallPoints.ChampYear = 2018)
       AND (tblOpenChampDivGenOverallPoints.RunnerSex = 'Joint')
       AND (tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints > 0))
ORDER BY tblMembershipArchive.RunnerDiv,tblOpenChampDivGenOverallPoints.OpenChampDivGenOverallPoints desc