<div class="navbar">
  <img class="logo" src="/assets/Images/Icons/gulogo.png" alt="logo" />
  <nav>
    <ul>
      <li>
        <a href="/dashboard">Attendance Report</a>
      </li>

      <?php
      // if($_COOKIE['role']=="HOD" || $_COOKIE['role']=="Coordinator"){
      ?>
      <li>
        <a href="/faculties">Faculties</a>
      </li>
      <li>
        <a href="/colleges">Colleges</a>
      </li>

      <li>
        <a href="/programs">Programs</a>
      </li>

      <li>
        <a href="/subjects">Subjects</a>
      </li>

      <li>
        <a href="/allocatesubjects"> Subject Allocation</a>
      </li>

      <li>
        <a href="/students">Students</a>
      </li>
      <? php // } 

      //if($_COOKIE['role']!="HOD"){
      ?>
      <li>
        <a href="/allsubjects">Attendance</a>
      </li>



      <?php //}
      ?>

      <li>
        <a href="/coordinators">Coordinator</a>
      </li>

      <li>
        <a href="/timeslots">Time Slot</a>
      </li>

      <li>
        <form action="/logout">
          <button>Logout</button>
        </form>
      </li>

    </ul>
  </nav>
</div>