<?php
include_once './backend/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="./src/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include './header.php' ?>
    <div class="content-wrapper p-3">
<div class="ndt-header-section mb-4">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="ndt-welcome-section">
          <h2 class="ndt-welcome-heading">Welcome back, <span class="ndt-user-name">Alex</span></h2>
          <p class="ndt-date-display">Today is March 21, 2025</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="ndt-quick-actions d-flex justify-content-end">
          <button class="btn ndt-action-btn ndt-create-task-btn">
            <i class="fas fa-plus-circle"></i> New Task
          </button>
          <button class="btn ndt-action-btn ndt-filter-btn">
            <i class="fas fa-filter"></i> Filter
          </button>
          <div class="ndt-user-profile-mini">
            <img src="assets/images/user-avatar.jpg" alt="User Profile" class="ndt-user-avatar">
            <div class="ndt-notification-indicator"></div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
<div class="row">
  <div class="col-lg-3 col-md-6">
    <div class="ndt-metric-card ndt-card-primary">
      <div class="ndt-card-body">
        <div class="ndt-card-icon">
          <i class="fas fa-tasks"></i>
        </div>
        <div class="ndt-card-content">
          <h3 class="ndt-card-value">150</h3>
          <p class="ndt-card-label">Active Tasks</p>
          <div class="ndt-trend-indicator">
            <i class="fas fa-arrow-up"></i>
            <span>12% from last week</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6">
    <div class="ndt-metric-card ndt-card-success">
      <div class="ndt-card-body">
        <div class="ndt-card-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="ndt-card-content">
          <h3 class="ndt-card-value">85</h3>
          <p class="ndt-card-label">Completed Tasks</p>
          <div class="ndt-trend-indicator">
            <i class="fas fa-arrow-up"></i>
            <span>8% from last week</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6">
    <div class="ndt-metric-card ndt-card-warning">
      <div class="ndt-card-body">
        <div class="ndt-card-icon">
          <i class="fas fa-clock"></i>
        </div>
        <div class="ndt-card-content">
          <h3 class="ndt-card-value">32</h3>
          <p class="ndt-card-label">Pending Tasks</p>
          <div class="ndt-trend-indicator">
            <i class="fas fa-arrow-down"></i>
            <span>5% from last week</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6">
    <div class="ndt-metric-card ndt-card-danger">
      <div class="ndt-card-body">
        <div class="ndt-card-icon">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="ndt-card-content">
          <h3 class="ndt-card-value">18</h3>
          <p class="ndt-card-label">Overdue Tasks</p>
          <div class="ndt-trend-indicator">
            <i class="fas fa-arrow-up"></i>
            <span>3% from last week</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
<div class="col-lg-8">
  <div class="ndt-card ndt-chart-card">
    <div class="ndt-card-header">
      <div class="ndt-card-header-content">
        <h4 class="ndt-card-title">Task Completion Trends</h4>
        <p class="ndt-card-subtitle">Weekly progress overview</p>
      </div>
      <div class="ndt-card-actions">
        <div class="btn-group ndt-time-filter">
          <button class="btn ndt-btn-sm ndt-btn-outline active">Week</button>
          <button class="btn ndt-btn-sm ndt-btn-outline">Month</button>
          <button class="btn ndt-btn-sm ndt-btn-outline">Quarter</button>
        </div>
      </div>
    </div>
    <div class="ndt-card-body">
      <canvas id="ndt-task-completion-chart" height="300"></canvas>
    </div>
  </div>
</div>
  
  <div class="col-lg-4">
    <div class="ndt-card ndt-chart-card">
      <div class="ndt-card-header">
        <div class="ndt-card-header-content">
          <h4 class="ndt-card-title">Task Distribution</h4>
          <p class="ndt-card-subtitle">By category</p>
        </div>
      </div>
      <div class="ndt-card-body">
        <canvas id="ndt-task-distribution-chart" height="300"></canvas>
      </div>
      <div class="ndt-chart-legend">
        <div class="ndt-legend-item">
          <span class="ndt-legend-color" style="background-color: #4e73df;"></span>
          <span class="ndt-legend-label">Development</span>
          <span class="ndt-legend-value">42%</span>
        </div>
        <div class="ndt-legend-item">
          <span class="ndt-legend-color" style="background-color: #1cc88a;"></span>
          <span class="ndt-legend-label">Design</span>
          <span class="ndt-legend-value">28%</span>
        </div>
        <div class="ndt-legend-item">
          <span class="ndt-legend-color" style="background-color: #36b9cc;"></span>
          <span class="ndt-legend-label">Marketing</span>
          <span class="ndt-legend-value">18%</span>
        </div>
        <div class="ndt-legend-item">
          <span class="ndt-legend-color" style="background-color: #f6c23e;"></span>
          <span class="ndt-legend-label">Research</span>
          <span class="ndt-legend-value">12%</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-lg-6">
    <div class="ndt-card">
      <div class="ndt-card-header">
        <div class="ndt-card-header-content">
          <h4 class="ndt-card-title">Team Productivity</h4>
          <p class="ndt-card-subtitle">Tasks completed per team member</p>
        </div>
        <div class="ndt-card-actions">
          <button class="btn ndt-btn-icon">
            <i class="fas fa-ellipsis-v"></i>
          </button>
        </div>
      </div>
      <div class="ndt-card-body">
        <canvas id="ndt-team-productivity-chart" height="250"></canvas>
      </div>
    </div>
  </div>
  
  <div class="col-lg-6">
    <div class="ndt-card">
      <div class="ndt-card-header">
        <div class="ndt-card-header-content">
          <h4 class="ndt-card-title">Team Workload</h4>
          <p class="ndt-card-subtitle">Current task allocation</p>
        </div>
        <div class="ndt-card-actions">
          <button class="btn ndt-btn-icon">
            <i class="fas fa-ellipsis-v"></i>
          </button>
        </div>
      </div>
      <div class="ndt-card-body">
        <div class="ndt-team-workload">
          <div class="ndt-team-member">
            <div class="ndt-member-info">
              <img src="assets/images/avatar-1.jpg" alt="Team Member" class="ndt-member-avatar">
              <div class="ndt-member-details">
                <h5 class="ndt-member-name">John Doe</h5>
                <p class="ndt-member-role">Lead Developer</p>
              </div>
            </div>
            <div class="ndt-workload-bar">
              <div class="progress ndt-progress">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <span class="ndt-workload-value">85%</span>
            </div>
          </div>
          
          <div class="ndt-team-member">
            <div class="ndt-member-info">
              <img src="assets/images/avatar-2.jpg" alt="Team Member" class="ndt-member-avatar">
              <div class="ndt-member-details">
                <h5 class="ndt-member-name">Sarah Johnson</h5>
                <p class="ndt-member-role">UI Designer</p>
              </div>
            </div>
            <div class="ndt-workload-bar">
              <div class="progress ndt-progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <span class="ndt-workload-value">65%</span>
            </div>
          </div>
          
          <div class="ndt-team-member">
            <div class="ndt-member-info">
              <img src="assets/images/avatar-3.jpg" alt="Team Member" class="ndt-member-avatar">
              <div class="ndt-member-details">
                <h5 class="ndt-member-name">Michael Chen</h5>
                <p class="ndt-member-role">Backend Developer</p>
              </div>
            </div>
            <div class="ndt-workload-bar">
              <div class="progress ndt-progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <span class="ndt-workload-value">92%</span>
            </div>
          </div>
          
          <div class="ndt-team-member">
            <div class="ndt-member-info">
              <img src="assets/images/avatar-4.jpg" alt="Team Member" class="ndt-member-avatar">
              <div class="ndt-member-details">
                <h5 class="ndt-member-name">Emily Wilson</h5>
                <p class="ndt-member-role">QA Specialist</p>
              </div>
            </div>
            <div class="ndt-workload-bar">
              <div class="progress ndt-progress">
                <div class="progress-bar bg-info" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <span class="ndt-workload-value">45%</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-lg-6">
    <div class="ndt-card ndt-todo-card">
      <div class="ndt-card-header">
        <div class="ndt-card-header-content">
          <h4 class="ndt-card-title">Today's Tasks</h4>
          <p class="ndt-card-subtitle">5 tasks remaining</p>
        </div>
        <div class="ndt-card-actions">
          <button class="btn ndt-btn-primary ndt-btn-sm">
            <i class="fas fa-plus"></i> Add Task
          </button>
        </div>
      </div>
      <div class="ndt-card-body">
        <div class="ndt-todo-list">
          <div class="ndt-todo-item ndt-priority-high">
            <div class="ndt-todo-checkbox">
              <input type="checkbox" id="task1" class="ndt-checkbox">
              <label for="task1" class="ndt-checkbox-label"></label>
            </div>
            <div class="ndt-todo-content">
              <h5 class="ndt-todo-title">Complete dashboard redesign</h5>
              <p class="ndt-todo-details">Finalize the new dashboard layout and components</p>
              <div class="ndt-todo-meta">
                <span class="ndt-todo-due"><i class="far fa-clock"></i> Today, 5:00 PM</span>
                <span class="ndt-todo-tag ndt-tag-design">Design</span>
              </div>
            </div>
            <div class="ndt-todo-actions">
              <button class="btn ndt-btn-icon ndt-btn-sm">
                <i class="fas fa-ellipsis-v"></i>
              </button>
            </div>
          </div>
          
          <div class="ndt-todo-item ndt-priority-medium">
            <div class="ndt-todo-checkbox">
              <input type="checkbox" id="task2" class="ndt-checkbox">
              <label for="task2" class="ndt-checkbox-label"></label>
            </div>
            <div class="ndt-todo-content">
  <h5 class="ndt-todo-title">Review API documentation</h5>
  <p class="ndt-todo-details">Check for any inconsistencies in the API endpoints</p>
  <div class="ndt-todo-meta">
    <span class="ndt-todo-due"><i class="far fa-clock"></i> Today, 3:00 PM</span>
    <span class="ndt-todo-tag ndt-tag-development">Development</span>
  </div>
</div>
<div class="ndt-todo-actions">
  <button class="btn ndt-btn-icon ndt-btn-sm">
    <i class="fas fa-ellipsis-v"></i>
  </button>
</div>
</div>

<div class="ndt-todo-item ndt-priority-low">
  <div class="ndt-todo-checkbox">
    <input type="checkbox" id="task3" class="ndt-checkbox">
    <label for="task3" class="ndt-checkbox-label"></label>
  </div>
  <div class="ndt-todo-content">
    <h5 class="ndt-todo-title">Schedule team meeting</h5>
    <p class="ndt-todo-details">Discuss sprint planning for next week</p>
    <div class="ndt-todo-meta">
      <span class="ndt-todo-due"><i class="far fa-clock"></i> Tomorrow, 10:00 AM</span>
      <span class="ndt-todo-tag ndt-tag-meeting">Meeting</span>
    </div>
  </div>
  <div class="ndt-todo-actions">
    <button class="btn ndt-btn-icon ndt-btn-sm">
      <i class="fas fa-ellipsis-v"></i>
    </button>
  </div>
</div>
</div>
</div>
</div>
</div>

<div class="col-lg-6">
  <div class="ndt-card">
    <div class="ndt-card-header">
      <div class="ndt-card-header-content">
        <h4 class="ndt-card-title">Recent Activities</h4>
        <p class="ndt-card-subtitle">Latest updates from your team</p>
      </div>
      <div class="ndt-card-actions">
        <button class="btn ndt-btn-icon">
          <i class="fas fa-ellipsis-v"></i>
        </button>
      </div>
    </div>
    <div class="ndt-card-body">
      <div class="ndt-activity-timeline">
        <div class="ndt-timeline-item">
          <div class="ndt-timeline-icon ndt-icon-primary">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="ndt-timeline-content">
            <h5 class="ndt-timeline-title">Task completed</h5>
            <p class="ndt-timeline-text">Sarah completed "Update user documentation"</p>
            <span class="ndt-timeline-time">10 minutes ago</span>
          </div>
        </div>
        
        <div class="ndt-timeline-item">
          <div class="ndt-timeline-icon ndt-icon-warning">
            <i class="fas fa-exclamation-circle"></i>
          </div>
          <div class="ndt-timeline-content">
            <h5 class="ndt-timeline-title">Task deadline approaching</h5>
            <p class="ndt-timeline-text">"Fix navigation bug" is due in 2 hours</p>
            <span class="ndt-timeline-time">30 minutes ago</span>
          </div>
        </div>
        
        <div class="ndt-timeline-item">
          <div class="ndt-timeline-icon ndt-icon-info">
            <i class="fas fa-comment"></i>
          </div>
          <div class="ndt-timeline-content">
            <h5 class="ndt-timeline-title">New comment</h5>
            <p class="ndt-timeline-text">John commented on "Implement search feature"</p>
            <span class="ndt-timeline-time">1 hour ago</span>
          </div>
        </div>
        
        <div class="ndt-timeline-item">
          <div class="ndt-timeline-icon ndt-icon-success">
            <i class="fas fa-plus-circle"></i>
          </div>
          <div class="ndt-timeline-content">
            <h5 class="ndt-timeline-title">New task created</h5>
            <p class="ndt-timeline-text">Michael created "Optimize database queries"</p>
            <span class="ndt-timeline-time">2 hours ago</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="row d-none mt-4">
  <div class="col-12">
    <div class="ndt-card">
      <div class="ndt-card-header">
        <div class="ndt-card-header-content">
          <h4 class="ndt-card-title">Project Timeline</h4>
          <p class="ndt-card-subtitle">Track your project milestones</p>
        </div>
        <div class="ndt-card-actions">
          <div class="btn-group ndt-view-filter">
            <button class="btn ndt-btn-sm ndt-btn-outline active">Week</button>
            <button class="btn ndt-btn-sm ndt-btn-outline">Month</button>
            <button class="btn ndt-btn-sm ndt-btn-outline">Quarter</button>
          </div>
        </div>
      </div>
      <div class="ndt-card-body">
        <div class="ndt-project-timeline">
          <div class="ndt-timeline-header">
            <div class="ndt-timeline-dates">
              <span>Mon</span>
              <span>Tue</span>
              <span>Wed</span>
              <span>Thu</span>
              <span>Fri</span>
              <span>Sat</span>
              <span>Sun</span>
            </div>
          </div>
          
          <div class="ndt-timeline-project">
            <div class="ndt-project-info">
              <h5 class="ndt-project-name">Website Redesign</h5>
              <p class="ndt-project-status">In Progress</p>
            </div>
            <div class="ndt-project-timeline">
              <div class="ndt-timeline-bar ndt-status-progress" style="grid-column: 1 / 5;">
                <span class="ndt-timeline-label">Design Phase</span>
              </div>
            </div>
          </div>
          
          <div class="ndt-timeline-project">
            <div class="ndt-project-info">
              <h5 class="ndt-project-name">Mobile App Development</h5>
              <p class="ndt-project-status">On Track</p>
            </div>
            <div class="ndt-project-timeline">
              <div class="ndt-timeline-bar ndt-status-complete" style="grid-column: 1 / 3;">
                <span class="ndt-timeline-label">Planning</span>
              </div>
              <div class="ndt-timeline-bar ndt-status-progress" style="grid-column: 3 / 7;">
                <span class="ndt-timeline-label">Development</span>
              </div>
            </div>
          </div>
          
          <div class="ndt-timeline-project">
            <div class="ndt-project-info">
              <h5 class="ndt-project-name">API Integration</h5>
              <p class="ndt-project-status">Delayed</p>
            </div>
            <div class="ndt-project-timeline">
              <div class="ndt-timeline-bar ndt-status-delayed" style="grid-column: 2 / 6;">
                <span class="ndt-timeline-label">Integration Testing</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


</div>
  

    <!-- </div> -->





    <!-- </div> -->
    <?php include './footer.php'; ?>
  </div>
  <script src="./src/js/jquery.min.js"></script>
  <script src="./src/js/bootstrap.bundle.min.js"></script>
  <script src="./src/js/adminlte.min.js"></script>
</body>

</html>