<?php
interface VCardInterface
{
	/**
	 * 将VCard文件中的单行信息送入，不包括begin end version 行
	 * 将行中的信息处理并存储
	 * @param [type] $string 要处理的信息
	 */
	public function setMessage($string);

	/**
	 * 获取Vcard中存在的信息
	 * @param  [type] $field VCard中的各种字段值如 N FN TEL等
	 * @return [array] 返回当前值下的信息 
	 * 如果不存在则返回null
	 * 存在则返输入字段相应的信息        
	 */
	public function getMessage($field);

	/**
	 * 判断输入的字段内容是否为空
	 * @param  [type]  $field 输入字段
	 * @return boolean        [description]
	 */
	public function isValid($field);

	/**
	 * 获取当前VCard对象的版本号信息
	 * @return [type] 版本号
	 */
	public function getVersion();

	/**
	 * 获取当前VCard对象中存在信息内容的字段集合
	 * @return [array] 返回由字段组成的集合
	 */
	public function getField();
}
?>