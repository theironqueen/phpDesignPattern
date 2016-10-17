<?php
class contacts
{
	public function import()
	{
		echo view::show('contacts/import');
	}

	public function processimport()
	{
		if (is_uploaded_file($_FILES['VCF']['tmp_name'])) {

			$builder = new importcontactsarraybuilder($_FILES['VCF']['tmp_name']);
			$imports = $builder->buildarray();
			unlink($_FILES['VCF']['tmp_name']);
			$currentuser = lib::getItem('user');

			//print_r($imports);

			foreach ($imports as $import) {
				$contact = new contact();
				$adaptor = new outlookcontactimportadapter($import);

				$contact->firstname = $adaptor->firstname;
				$contact->middlename = $adaptor->middlename;
				$contact->lastname = $adaptor->lastname;
				$contact->ownerid = $currentuser->id;
				$contact->save();

				$adaptor = new contactgroupadapter($import);
				$groups = $adaptor->groups;

				foreach ($groups as $groupname) {
					$group = new contactgroup();
					$group->label = $groupname;
					$group->contactid = $contact->id;
					$group->save();

					$methods = new contactmethodscollection($group);
					$methods->generateimportmethods($import);
					$methods->saveall();
					
				}
			}
			lib::sendto();
		} 
		else {
			lib::seterror(array('Please upload a file.'));
			lib::sendto('/contacts/import');
		}
	}

	public function view()
	{
		$controller = lib::getItem('controller');

		if (empty($controller->params[0])) {
			lib::sendto();
		}
		else {
			$contact = new contact((int) $controller->params[0]);
			$groups = new contactgroupscollection($contact);
			$groups->getwithdata();
			echo view::show('contacts/view', array('contact'=>$contact, 'groups'=>$groups));
		}
	}

	public function add()
	{
		echo view::show('contacts/add');
	}
}
?>