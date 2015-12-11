<?php

if (! function_exists('createAuthorsFields')) {
    /**
     * Creazione campi autore.
     *
     * @return void
     */
    function createAuthorsFields(Illuminate\Database\Schema\Blueprint $table)
    {
        $table->integer('created_by')->unsigned()->nullable();
        $table->integer('updated_by')->unsigned()->nullable();
        $table->integer('deleted_by')->unsigned()->nullable();
    }
}

if (! function_exists('removeAuthorsFields')) {
    /**
     * Rimozione campi autore.
     *
     * @return void
     */
    function removeAuthorsFields(Illuminate\Database\Schema\Blueprint $table)
    {
        $table->dropColumn('created_by');
        $table->dropColumn('updated_by');
        $table->dropColumn('deleted_by');
    }
}

if (! function_exists('formDelete')) {
    /**
     * Crea la form per la cancellazione di un record.
     *
     * @return string
     */
    function formDelete($url)
    {
        $form = Form::open(['url' => $url, 'method' => 'DELETE', 'class' => 'form-delete']);
        $form .= '<button type="submit" class="btn btn-xs btn-danger" data-confirm="'.trans('app.common.confirm').'"><span class="glyphicon glyphicon-remove"></span></button>';
        $form .= Form::close();

        return $form;
    }
}
