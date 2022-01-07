SELECT DISTINCT tblOpenChampWMAOverallPoints.RunnerID AS RunnerID,
tblRunners.RunnerFirstName AS RunnerFirstName,
tblRunners.RunnerSurname AS RunnerSurname,
tblRunners.RunnerSex AS RunnerSex,
tblOpenChampWMAOverallPoints.OpenChampWMAOverallPoints AS OpenChampWMAOverallPoints,
tblOpenChampWMAOverallPoints.ChampionshipID AS ChampionshipID,
tblOpenChampWMAOverallPoints.ChampYear AS ChampYear
FROM (tblOpenChampWMAOverallPoints 
       JOIN tblRunners on((tblOpenChampWMAOverallPoints.RunnerID = tblRunners.RunnerID)))
WHERE (tblOpenChampWMAOverallPoints.ChampYear = 2021
       AND tblOpenChampWMAOverallPoints.OpenChampWMAOverallPoints > 0)
ORDER BY tblRunners.RunnerSex desc,
tblOpenChampWMAOverallPoints.OpenChampWMAOverallPoints desc