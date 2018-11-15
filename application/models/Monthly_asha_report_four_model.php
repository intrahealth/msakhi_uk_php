<?php  

class Monthly_asha_report_four_model extends Ci_model 
{
	public function __construct()
	{

	}

	public function get_report()
	{
		$ASHAID = $this->input->post('ashaid');

				$query = "SELECT a.*, c.ANMName, e.SubCenterName from (
				SELECT
				a.ASHAID,
				a.ASHAName,
				group_concat(c.VillageName) as Villages
				FROM
				mstasha a
				left JOIN ashavillage b ON
				a.ASHAID = b.ASHAID
				inner join mstvillage c 
				on b.VillageID = c.VillageID and c.LanguageID = 2
				where a.LanguageID = 2 and a.IsActive = 1
				group by a.ASHAID)a 
				left join anmasha b 
				on a.ASHAID = b.ASHAID
				left join mstanm c 
				on b.ANMID = c.ANMID and c.LanguageID = 2 and c.IsActive = 1
				left join anmsubcenter d 
				on c.ANMID = d.ANMID 
				left join mstsubcenter e 
				on d.SubCenterID = e.SubCenterID and e.LanguageID = 2
				where a.ASHAID = ?";

					// die($query);

				$result = $this->db->query($query, [$ASHAID])->result();

					// if (count($result) < 1) {
					// 	die("ERROR: No ASHA record found with this ASHAID = $ASHAID");
					// }

				$content['asha_data'] = $result[0];

				/*Village Counts*/

				$query = "SELECT
				COUNT(*) AS total
				FROM
				mstvillage a
				INNER JOIN ashavillage b ON
				a.VillageID = b.VillageID
				INNER JOIN mstasha c ON
				b.ASHAID = c.ASHAID
				WHERE
				a.IsDeleted = 0 AND a.LanguageID = 1 AND c.LanguageID = 1 AND c.IsDeleted = 0 AND c.IsActive = 1 AND c.AshaID = ? ";

				$content['village_count'] = $this->db->query($query,[$ASHAID])->result()[0];

				/*Housold Counts*/

				$query = "select count(*) as total
				from tblhhsurvey  WHERE IsDeleted = 0 and ServiceProviderID = ?";


				$content['household_count'] = $this->db->query($query, [$ASHAID])->result()[0];

				/*Cast Id Query*/


				$query = "SELECT * FROM (
		    SELECT COUNT(*) as sc from tblhhsurvey WHERE CasteID = 1 AND IsDeleted = 0 and IsActive = 1 AND ServiceProviderID = $ASHAID ) a
		    INNER JOIN ( SELECT COUNT(*) as st from tblhhsurvey WHERE CasteID = 2 AND IsDeleted = 0 and IsActive = 1 AND ServiceProviderID =  $ASHAID ) b 
		    INNER JOIN ( SELECT COUNT(*) as obc from tblhhsurvey WHERE CasteID = 3 AND IsDeleted = 0 and IsActive = 1 AND ServiceProviderID =  $ASHAID ) c 
		    INNER JOIN ( SELECT COUNT(*) as other from tblhhsurvey WHERE CasteID = 4 AND IsDeleted = 0 and IsActive = 1 AND ServiceProviderID = $ASHAID ) d";
		    // die($query);


		    $content['cast_id'] = $this->db->query($query)->result()[0];

		    // print_r($content['cast_id']);die();


		// 		$query = "SELECT
		//     a.male,
		//     b.female,
		//     a.male + b.female as total
		// FROM
		//     (
		//     SELECT
		//         COUNT(*) as male
		//     FROM
		//         tblhhfamilymember a
		//     INNER JOIN tblhhsurvey b ON
		//         a.HHSurveyGUID = b.HHSurveyGUID
		//     WHERE
		//         a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND a.AshaID = $ASHAID
		// ) a
		// INNER JOIN(
		//     SELECT COUNT(*) AS female
		//     FROM
		//         tblhhfamilymember a
		//     INNER JOIN tblhhsurvey b ON
		//         a.HHSurveyGUID = b.HHSurveyGUID
		//     WHERE
		//         a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND a.AshaID = $ASHAID
		// ) b";

					$query = "SELECT
					a.total as male,
					b.total as female,
					a.total + b.total as total FROM 
					( SELECT
					count(*) as total
					FROM
					tblhhfamilymember a
					INNER JOIN tblhhsurvey b ON
					a.HHSurveyGUID = b.HHSurveyGUID
					WHERE
					a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
					(
					CASE
					WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
					WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
					) between 0 and 42000 ) a

					INNER JOIN
					(
					SELECT
					count(*) as total
					FROM
					tblhhfamilymember a
					INNER JOIN tblhhsurvey b ON
					a.HHSurveyGUID = b.HHSurveyGUID
					WHERE
					a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
					(
					CASE
					WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
					WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
					) between 0 and 42000 
				) b";


				$content['total_members'] = $this->db->query($query)->result()[0];

				// print_r($content['total_members']); die();

				

				$query = "SELECT
				a.total as male,
				b.total as female,
				a.total + b.total as total FROM 
				( SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 0 and 365 ) a

				INNER JOIN
				(
				SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 0 and 365 
			) b";
			// die($query);

			$content['total_population_zero_to_one'] = $this->db->query($query)->result()[0];

			// print_r($content['total_population_zero_to_one']); die();



			$query = "SELECT
				a.total as male,
				b.total as female,
				a.total + b.total as total FROM 
				( SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 366 and 730 ) a

				INNER JOIN
				(
				SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 366 and 730 
			) b";
			// die($query);

			$content['total_population_one_to_two'] = $this->db->query($query)->result()[0];

			// print_r($content['total_population_one_to_two']); die();


			$query = "SELECT
				a.total as male,
				b.total as female,
				a.total + b.total as total FROM 
				( SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 731 and 1825 ) a

				INNER JOIN
				(
				SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 731 and 1825 
			) b";
			// die($query);

			$content['total_population_two_to_five'] = $this->db->query($query)->result()[0];

			// print_r($content['total_population_two_to_five']); die();



			$query = "SELECT
				a.total as male,
				b.total as female,
				a.total + b.total as total FROM 
				( SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 1826 and 3652 ) a

				INNER JOIN
				(
				SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 1826 and 3652 
			) b";
			// die($query);

			$content['total_population_five_to_ten'] = $this->db->query($query)->result()[0];

			// print_r($content['total_population_five_to_ten']); die();


			$query = "SELECT
				a.total as male,
				b.total as female,
				a.total + b.total as total FROM 
				( SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 3653 and 6935 ) a

				INNER JOIN
				(
				SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 3653 and 6935 
			) b";
			// die($query);

			$content['total_population_ten_to_ninteen'] = $this->db->query($query)->result()[0];

			// print_r($content['total_population_ten_to_ninteen']); die();



			$query = "SELECT
				a.total as male,
				b.total as female,
				a.total + b.total as total FROM 
				( SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 6936 and 21900 ) a

				INNER JOIN
				(
				SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 6936 and 21900 
			) b";
			// die($query);

			$content['total_population_ninteen_to_sixty'] = $this->db->query($query)->result()[0];

			// print_r($content['total_population_ninteen_to_sixty']); die();



			$query = "SELECT
				a.total as male,
				b.total as female,
				a.total + b.total as total FROM 
				( SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 21901 AND 42000 ) a

				INNER JOIN
				(
				SELECT
				count(*) as total
				FROM
				tblhhfamilymember a
				INNER JOIN tblhhsurvey b ON
				a.HHSurveyGUID = b.HHSurveyGUID
				WHERE
				a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
				(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
				) between 21901 AND 42000
			) b";
			// die($query);

			$content['total_population_sixty_and_more'] = $this->db->query($query)->result()[0];

			// print_r($content['total_population_sixty_and_more']); die();


			return $content;
	}
}