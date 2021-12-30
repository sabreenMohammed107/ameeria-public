<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ViewInvoicesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }

/**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView(): string
    {
        return <<<SQL

            CREATE VIEW view_invoices_data AS
                SELECT
                    invo.id,
                    invo.invoice_no,
                    invo.date,
                    invo.e_invoice_type,
                    invo.taxable,
                    invo.subtotal,
                    invo.tax,
                    invo.total,
                    invo.person_name,
                    invo.person_nid,
                    invType.name AS type_name,
                    client.tax_registration,
                    client.name AS client_name,
                    city.name AS governate,
                    client.city,
                    client.street,
                    client.build,
                    client.email,
                    invitem.id AS itemid,
                    invitem.invoice_id,
                    invitem.quantity,
                    invitem.price,
                    item.name AS itemdescription,
                    item.code AS itemcode,
                    unit.standard_code AS unittype
                FROM invoice_items AS invitem
                JOIN invoices AS invo ON invo.id = invitem.invoice_id
                JOIN invoice_types AS invtype ON invtype.id = invo.type_id
                LEFT JOIN clients AS client ON client.id = invo.client_id
                LEFT JOIN cities AS city ON city.id = client.city_id
                JOIN items AS item ON item.id = invitem.item_id
                JOIN units AS unit ON unit.id = item.exchange_unit_id
                WHERE invo.status = 0

            SQL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function dropView(): string
    {
        return
        // <<<SQL
<<<EOF
DROP VIEW IF EXISTS `view_invoices_data`;

EOF;
            // SQL;
    }

}
