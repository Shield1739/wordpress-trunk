<?php

/**
 * @group sanitize_sql_orderby
 *
 * @covers ::sanitize_sql_orderby
 */
class Tests_Formatting_SanitizeOrderby extends WP_UnitTestCase {

	/**
	 * @dataProvider valid_orderbys
	 */
	public function test_valid( $orderby ) {
		$this->assertSame( $orderby, sanitize_sql_orderby( $orderby ) );
	}
	public function valid_orderbys() {
		return array(
			array( '1' ),
			array( '1 ASC' ),
			array( '1 ASC, 2' ),
			array( '1 ASC, 2 DESC' ),
			array( '1 ASC, 2 DESC, 3' ),
			array( '       1      DESC' ),
			array( 'field ASC' ),
			array( 'field1 ASC, field2' ),
			array( 'field_1 ASC, field_2 DESC' ),
			array( 'field1, field2 ASC' ),
			array( '`field1`' ),
			array( '`field1` ASC' ),
			array( '`field` ASC, `field2`' ),
			array( 'RAND()' ),
			array( '   RAND(  )   ' ),
		);
	}

	/**
	 * @dataProvider invalid_orderbys
	 */
	public function test_invalid( $orderby ) {
		$this->assertFalse( sanitize_sql_orderby( $orderby ) );
	}
	public function invalid_orderbys() {
		return array(
			array( '' ),
			array( '1 2' ),
			array( '1, 2 3' ),
			array( '1 DESC, ' ),
			array( 'field-1' ),
			array( 'field DESC,' ),
			array( 'field1 field2' ),
			array( 'field RAND()' ),
			array( 'RAND() ASC' ),
			array( '`field1` ASC, `field2' ),
			array( 'field, !@#$%^' ),
		);
	}
}
