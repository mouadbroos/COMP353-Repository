<?php $this->extend('/Common/sidebar'); ?>
<?php 
use Cake\I18n\Time;
	$this->set('sidebar_title', $section->course->name.' \ Section '.$section->id.'<br>'.$section->semester->name); 


	$linkgroups;
	if($user->isStudent($section->id)){
		$groupurl = ['controller' => 'Teams', 
				 		   'action' => 'index',
				 		   $section->id];
		if($group = $user->getGroup($section->id)){
			$groupurl = ['controller' => 'Teams', 
				 		   'action' => 'view',
				 		   $group->id];
		}
		$linkgroups[] = [
			'title' => 'Student',
			'links' => [
				['text' => 'Section Page', 
				 'url' => ['controller' => 'Sections', 
				 		   'action' => 'view',
				 		   $section->id]],
				['text' => 'Assignments', 
				 'url' => ['controller' => 'Assignments', 
				 		   'action' => 'index',
				 		   $section->id]]

			]];
	}

	if($user->isTA($section->id)){
		$linkgroups[] = [
			'title' => 'TA Options',
			'links' => [
				['text' => 'View groups', 
				 'url' => ['controller' => 'Teams', 
				 		   'action' => 'index',
				 		   $section->id]],
				['text' => 'Add group', 
				 'url' => ['controller' => 'Teams', 
				 		   'action' => 'add',
				 		   $section->id]],
				['text' => 'View Assignments', 
				 'url' => ['controller' => 'Assignments', 
				 		   'action' => 'index',
				 		   $section->id]],
				['text' => 'Add Assignment', 
				 'url' => ['controller' => 'Assignments', 
				 		   'action' => 'Add',
				 		   $section->id]]
			]];
	}

	if($user->isInstructor($section->id)){
		$linkgroups[] = [
			'title' => 'Instructor Options',
			'links' => [
				['text' => 'Manage assignments', 
				 'url' => ['controller' => 'Assignments', 
				 		   'action' => 'index',
				 		   	$section->id]],
				['text' => 'Manage groups', 
				 'url' => ['controller' => 'Teams', 
				 		   'action' => 'index',
				 		   $section->id]],
				['text' => 'Set filesize limit', 
				 'url' => []]
			]];
	}

	if($user->isAdmin()){
		$links = 
			[
				['text' => 'Manage Groups', 
				 'url' => ['controller' => 'Teams', 
				 		   'action' => 'index',
				 		   	$section->id]]
			];

		$semesterEnd = $section->semester->end_date;
        if($semesterEnd <= Time::now()->subHours(4)){
            $links[] = 
           		['text' => 'Get Archive', 
				 'url' => ['controller' => 'Sections', 
				 		   'action' => 'archiveFiles',
				 		   	$section->id]];
        }
		$linkgroups[] = [
			'title' => 'Admin tools',
			'links' => $links];
	}

	$this->set('linkgroups', $linkgroups);
?>

<?= $this->fetch('content'); ?>