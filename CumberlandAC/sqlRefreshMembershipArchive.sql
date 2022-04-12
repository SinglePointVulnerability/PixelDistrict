INSERT INTO tblMembershipArchive (
	RunnerID
	,MembershipYear
	,RunnerDiv
	)
SELECT RunnerID
	,2021 AS MembershipYear
	,RunnerDiv
FROM tblRunners