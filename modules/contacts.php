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

	public function processadd()
	{
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$contact = new contact();
		$contact->firstname = $firstname;
		$contact->lastname = $lastname;
		$contact->middlename = $middlename;

		$currentuser = lib::getItem('user');

		$contact->ownerid = $currentuser->id;
		$contact->save();

		$this->addMethods($_POST['type'], $contact);

		lib::sendto("/contacts/view/{$contact->id}");
	}

	public function addMethods($types, contact $contact)
	{
		foreach ($types as $groupid => $type) {
			if (!empty($type['label'])) {
				$group = new contactgroup();
				$group->contactid = $contact->id;
				$group->label = $type['label'];

				foreach ($type['methodtype'] as $methodtypekey => $methodtype) {
					if (!empty($methodtype)
						&& !empty($type['methodvalue'][$methodtypekey])) {
						if (is_null($group->id)) $group->save();
						$method = new contactmethod();
						$method->contactgroupid = $group->id;
						$method->type = $methodtype;
						$method->value = $type['methodvalue'][$methodtypekey];
						$method->save();
					}
				}
			}
		}
	}

	public function edit()
	{
		$controller = lib::getItem('controller');

		if (empty($controller->params[0])) {
			lib::sendto();
		}
		else {
			$contact = new contact((int) $controller->params[0]);
			$contactgroups = new contactgroupscollection($contact);
			$contactgroups->getwithdata();
			echo view::show('contacts/edit',array('contact'=>$contact,'groups'=>$contactgroups));
		}
	}

	public function processedit()
	{
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$id = $_POST['id'];

		$contact = new contact($id);
		$contact->firstname = $firstname;
		$contact->middlename = $middlename;
		$contact->lastname = $lastname;

		$contact->save();

		$this->deleteMethods($contact);
		$this->addMethods($_POST['type'], $contact);

		lib::sendto("/contacts/view/{$contact->id}");
	}

	public function deleteMethods(contact $contact)
	{
		$connection = db::factory('mysql');

		$sql = "delete g.*, m.* from contactgroup g left join contactmethod m on g.id=m.contactgroupid where contactid={$contact->id}";
		$results = $connection->execute($sql);
	}

	public function processdelete()
	{
		$controller = lib::getItem('controller');
		$connection = db::factory('mysql');
		$id = (int)$controller->params[0];
		$contact = new contact($id);

		$sql = "delete from contact where id={$contact->id}";
		$result = $connection->execute($sql);
		$this->deleteMethods($contact);
		lib::sendto();
	}
}
?>