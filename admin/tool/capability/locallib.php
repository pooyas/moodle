<?php


/**
 * Functions used by the capability tool.
 *
 * @package    admin_tool
 * @subpackage capability
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Calculates capability data organised by context for the given roles.
 *
 * @param string $capability The capability to get data for.
 * @param array $roles An array of roles to get data for.
 * @return context[] An array of contexts.
 */
function tool_capability_calculate_role_data($capability, array $roles) {
    global $DB;

    $systemcontext = context_system::instance();
    $roleids = array_keys($roles);

    // Work out the bits needed for the SQL WHERE clauses.
    $params = array($capability);
    list($sqlroletest, $roleparams) = $DB->get_in_or_equal($roleids);
    $params = array_merge($params, $roleparams);
    $sqlroletest = 'AND roleid ' . $sqlroletest;

    // Get all the role_capabilities rows for this capability - that is, all
    // role definitions, and all role overrides.
    $sql = 'SELECT id, roleid, contextid, permission
              FROM {role_capabilities}
             WHERE capability = ? '.$sqlroletest;
    $rolecaps = $DB->get_records_sql($sql, $params);

    // In order to display a nice tree of contexts, we need to get all the
    // ancestors of all the contexts in the query we just did.
    $sql = 'SELECT DISTINCT con.path, 1
              FROM {context} con
              JOIN {role_capabilities} rc ON rc.contextid = con.id
             WHERE capability = ? '.$sqlroletest;
    $relevantpaths = $DB->get_records_sql_menu($sql, $params);
    $requiredcontexts = array($systemcontext->id);
    foreach ($relevantpaths as $path => $notused) {
        $requiredcontexts = array_merge($requiredcontexts, explode('/', trim($path, '/')));
    }
    $requiredcontexts = array_unique($requiredcontexts);

    // Now load those contexts.
    list($sqlcontexttest, $contextparams) = $DB->get_in_or_equal($requiredcontexts);
    $contexts = get_sorted_contexts('ctx.id ' . $sqlcontexttest, $contextparams);

    // Prepare some empty arrays to hold the data we are about to compute.
    foreach ($contexts as $conid => $con) {
        $contexts[$conid]->children = array();
        $contexts[$conid]->rolecapabilities = array();
    }

    // Put the contexts into a tree structure.
    foreach ($contexts as $conid => $con) {
        $context = context::instance_by_id($conid);
        try {
            $parentcontext = $context->get_parent_context();
            if ($parentcontext) { // Will be false if $context is the system context.
                $contexts[$parentcontext->id]->children[] = $conid;
            }
        } catch (dml_missing_record_exception $e) {
            // Ignore corrupt context tree structure here. Don't let it break
            // showing the rest of the report.
            continue;
        }
    }

    // Put the role capabilities into the context tree.
    foreach ($rolecaps as $rolecap) {
        $contexts[$rolecap->contextid]->rolecapabilities[$rolecap->roleid] = $rolecap->permission;
    }

    // Fill in any missing rolecaps for the system context.
    foreach ($roleids as $roleid) {
        if (!isset($contexts[$systemcontext->id]->rolecapabilities[$roleid])) {
            $contexts[$systemcontext->id]->rolecapabilities[$roleid] = CAP_INHERIT;
        }
    }

    return $contexts;
}