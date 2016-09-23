/**
 * Handles the way user grid is filtered
 */
$(document).ready(function(){
    /* ============ Sort role asce =========== */
    $('#generalContainer').on('click', '#sortRoleAsc',  function() {
        $("#sortByHidden").val("role");
        $("#sortOrderHidden").val("asc");

        /* Regenerate grid again */
        buildUserList.call(this);
    });

    /* ============ Sort role desc  =========== */
    $('#generalContainer').on('click', '#sortRoleDesc',  function() {
        $("#sortByHidden").val("role");
        $("#sortOrderHidden").val("desc");

        /* Regenerate grid again */
        buildUserList.call(this);
    });

    /* ============ Sort username asc  =========== */
    $('#generalContainer').on('click', '#sortUsernameAsc',  function() {
        $("#sortByHidden").val("username");
        $("#sortOrderHidden").val("asc");

        /* Regenerate grid again */
        buildUserList.call(this);
    });

    /* ============ Sort username desc  =========== */
    $('#generalContainer').on('click', '#sortUsernameDesc',  function() {
        $("#sortByHidden").val("username");
        $("#sortOrderHidden").val("desc");

        /* Regenerate grid again */
        buildUserList.call(this);
    });

    /* ============ Sort email asc  =========== */
    $('#generalContainer').on('click', '#sortEmailAsc',  function() {
        $("#sortByHidden").val("email");
        $("#sortOrderHidden").val("asc");

        /* Regenerate grid again */
        buildUserList.call(this);
    });

    /* ============ Sort email desc  =========== */
    $('#generalContainer').on('click', '#sortEmailDesc',  function() {
        $("#sortByHidden").val("email");
        $("#sortOrderHidden").val("desc");

        /* Regenerate grid again */
        buildUserList.call(this);
    });
});