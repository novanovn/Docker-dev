<?php
  // Accept a parameter called "deptno" from a form or the query string.
  $deptno  = $_REQUEST['deptno'];

  // Default the value if it is not present.
  if ($deptno == "") {
    $deptno = 10;
  }

  // Connect to the SCOTT schema of the 10.8.1.180/stormdb database.
  $conn=oci_connect("scott", "tiger", "10.8.1.180/stormdb");
  if ( ! $conn ) {
    echo "Unable to connect: " . var_dump( oci_error() );
    die();
  }
  else {
    echo "Connected sucessfully.<br /><br />\n";
  }

  example_query($conn, $deptno);

  example_insert($conn, $deptno);
  example_query($conn, $deptno);

  example_update($conn);
  example_query($conn, $deptno);

  example_delete($conn);
  example_query($conn, $deptno);

  oci_close($conn);
  echo "<br />Disconnected sucessfully.<br /><br />\n";


  function example_query ($conn, $deptno) {
    echo "Return employees for department $deptno.<br />\n";

    // Parse a query containing a bind variable.
    $stmt = oci_parse($conn, "SELECT * ".
                             "FROM   emp ".
                             "WHERE  deptno = :deptno ".
                             "ORDER BY empno");

    // Bind the value into the parsed statement.
    oci_bind_by_name($stmt, ":deptno", $deptno);

    // Execute the completed statement.
    oci_execute($stmt, OCI_DEFAULT);

    while (oci_fetch($stmt)) {
    	$empno    = oci_result($stmt, "EMPNO");
    	$ename    = oci_result($stmt, "ENAME");
    	$job      = oci_result($stmt, "JOB");
    	$mgr      = oci_result($stmt, "MGR");
    	$hiredate = oci_result($stmt, "HIREDATE");
    	$sal      = oci_result($stmt, "SAL");
    	$comm     = oci_result($stmt, "COMM");
    	$deptno   = oci_result($stmt, "DEPTNO");

    	// Do something with the data
    	echo "empno=$empno ";
    	echo "ename=$ename ";
    	echo "job=$job ";
    	echo "mgr=$mgr ";
    	echo "hiredate=$hiredate ";
    	echo "sal=$sal ";
    	echo "comm=$comm ";
    	echo "deptno=$deptno<br />\n";
    }
    oci_free_statement($stmt);
  }


  function example_insert ($conn, $deptno) {
    echo "<br />Insert a new employee.<br />\n";

    // Parse an insert statement containing bind variables.
    $stmt = oci_parse($conn, "INSERT INTO emp (empno, ename, job, deptno) ".
                             "VALUES (:empno, :ename, :job, :deptno)");

    $empno  = 9999;
    $ename  = "HALL";
    $job    = "DBA";

    // Bind the values into the parsed statement.
    oci_bind_by_name($stmt, ":empno", $empno);
    oci_bind_by_name($stmt, ":ename", $ename);
    oci_bind_by_name($stmt, ":job", $job);
    oci_bind_by_name($stmt, ":deptno", $deptno);

    // Execute the completed statement.
    oci_execute($stmt, OCI_DEFAULT);
    oci_commit($conn);
    oci_free_statement($stmt);
    echo "Employee inserted sucessfully.<br />\n";
  }


  function example_update ($conn) {
    echo "<br />Update an existing employee.<br />\n";

    // Parse an update statement containing bind variables.
    $stmt = oci_parse($conn, "UPDATE emp ".
                             "SET    ename = :ename, ".
                             "       job   = :job ".
                             "WHERE  empno = :empno");

    $empno = 9999;
    $ename = "TIM_HALL";
    $job   = "DBA/DEV";

    // Bind the values into the parsed statement.
    oci_bind_by_name($stmt, ":empno", $empno);
    oci_bind_by_name($stmt, ":ename", $ename);
    oci_bind_by_name($stmt, ":job", $job);

    // Execute the completed statement.
    oci_execute($stmt, OCI_DEFAULT);
    oci_commit($conn);
    oci_free_statement($stmt);
    echo "Employee updated sucessfully.<br />\n";
  }


  function example_delete ($conn) {
    echo "<br />Delete an existing employee.<br />\n";

    // Parse a delete statement containing bind variables.
    $stmt = oci_parse($conn, "DELETE FROM emp ".
                             "WHERE  empno = :empno");

    $empno = 9999;

    // Bind the values into the parsed statement.
    oci_bind_by_name($stmt, ":empno", $empno);

    // Execute the completed statement.
    oci_execute($stmt, OCI_DEFAULT);
    oci_commit($conn);
    oci_free_statement($stmt);
    echo "Employee deleted sucessfully.<br />\n";
  }
?>
