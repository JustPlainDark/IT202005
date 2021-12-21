# Project Name: Simple Arcade
## Project Summary: This project will create a simple Arcade with scoreboards and competitions based on the implemented game.
## Github Link: (Prod Branch of Project Folder)
## Project Board Link: 
## Website Link: (Heroku Prod of Project folder)
## Your Name: David Garcia

<!--
### Line item / Feature template (use this for each bullet point)
#### Don't delete this

- [ ] \(mm/dd/yyyy of completion) Feature Title (from the proposal bullet point, if it's a sub-point indent it properly)
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
### End Line item / Feature Template
--> 
### Proposal Checklist and Evidence

- Milestone 1
- [x] 11/7/2021 Users will be able to register a new account  
  - https://github.com/JustPlainDark/IT202005/pull/11
  - Direct Link: https://dg533-prod.herokuapp.com/Project/register.php
  - Form Fields
    - [x] 11/7/2021 Username, email, password, confirm password(other fields optional)
    - [x] 11/7/2021 Email is required and must be validated
    - [x] 11/7/2021 Username is required
    - [x] 11/7/2021 Confirm passwords match
  - Users Table
    - [x] 10/7/2021 Id, username, email, password (60 characters), created, modified
      - https://github.com/JustPlainDark/IT202005/pull/7
  - [x] 11/1/21 Password must be hashed (plain text passwords will lose points)
    - https://github.com/JustPlainDark/IT202005/pull/11
  - [x] 10/7/21 Email should be unique
    - https://github.com/JustPlainDark/IT202005/pull/7
  -  [x] 11/8/21 Username should be unique
    - https://github.com/JustPlainDark/IT202005/pull/14
  - [] System should let user know if username or email is taken and allow the user to correct the error without wiping/clearing the form
    - https://github.com/JustPlainDark/IT202005/pull/14
    - The system does alert if an email or username is already taken but it wipes the form. 
    - [] The only fields that may be cleared are the password fields
    - https://github.com/JustPlainDark/IT202005/pull/14
    - This one doesn't work as entering credentials will still clear all the fields. I wasn't sure how to get it working and wanted to focus on other features.
- [x] User will be able to login to their account (given they enter the correct credentials)
  - Direct Link: https://dg533-prod.herokuapp.com/Project/login.php
  - https://github.com/JustPlainDark/IT202005/pull/43
  - Form
    - [x] User can login with email or username
      - This can be done as a single field or as two separate fields
      - https://github.com/JustPlainDark/IT202005/pull/43
    - [x] 11/3/2021 Password is required
    - https://github.com/JustPlainDark/IT202005/pull/11
  - [x] User should see friendly error messages when an account either doesn't exist or if passwords don't match
    - https://github.com/JustPlainDark/IT202005/pull/13
  - [x] Logging in should fetch the user's detail (and roles) and save them into the session.
    - https://github.com/JustPlainDark/IT202005/pull/40
  - User will be directed to a landing page upon login
    - [x] This is a protected page (non-logged in users shouldn't have access)
      - https://github.com/JustPlainDark/IT202005/pull/11
    - This can be home, profile, a dashboard, etc
- [x] Users will be able to logout
  - [x] Logging out will redirect to login page
    - https://github.com/JustPlainDark/IT202005/pull/11
  - [] User should see a message that they’ve successfully logged out
    - https://github.com/JustPlainDark/IT202005/pull/13
    - Logout message occurs on logout page and doesn't appear on login redirect
  - [x] Session should be destroyed (so the back button doesn’t allow them access back in)
    - https://github.com/JustPlainDark/IT202005/pull/11
- [x] Basic Security rules implemented
  - Authentication:
    - [x] Function to check if user is logged in
      - https://github.com/JustPlainDark/IT202005/pull/11
    - [x] Function should be called on appropriate pages that only allow logged in users
      - https://github.com/JustPlainDark/IT202005/pull/14
  - Roles/Authorization:
    - Have a roles table (see below)
- [x] Basic Roles Implemented
  - [x] Have a Roles table	(id, name, description, is_active, modified, created)
    - https://github.com/JustPlainDark/IT202005/pull/40
  - [x] Have a User Roles table (id, user_id, role_id, is_active, created, modified)
    - https://github.com/JustPlainDark/IT202005/pull/40
  - [x] Include a function to check if a user has a specific role (we won’t use it for this milestone but it should be usable in the future)
    - https://github.com/JustPlainDark/IT202005/pull/40
- [x] 12/21/2021 Site should have basic styles/theme applied; everything should be styled
  - I.e. forms/input, navigation bar, etc
  - https://github.com/JustPlainDark/IT202005/pull/48
- [x] Any output messages/errors should be “user friendly”
  - Any technical errors or debug output displayed will result in a loss of points
  - https://github.com/JustPlainDark/IT202005/pull/13
- [x] User will be able to see their profile
  - Email, username, etc
  - https://github.com/JustPlainDark/IT202005/pull/14
- [x] User will be able to edit their profile
  - [x] Changing username/email should properly check to see if it’s available before allowing the change
    - https://github.com/JustPlainDark/IT202005/pull/14
  - [x] Any other fields should be properly validated
    - https://github.com/JustPlainDark/IT202005/pull/14
  - [x] Allow password reset (only if the existing correct password is provided)
   - Hint: logic for the password check would be similar to login
   - https://github.com/JustPlainDark/IT202005/pull/14
- Milestone 2
- Milestone 3
- Milestone 4
### Intructions
#### Don't delete this
1. Pick one project type
2. Create a proposal.md file in the root of your project directory of your GitHub repository
3. Copy the contents of the Google Doc into this readme file
4. Convert the list items to markdown checkboxes (apply any other markdown for organizational purposes)
5. Create a new Project Board on GitHub
   - Choose the Automated Kanban Board Template
   - For each major line item (or sub line item if applicable) create a GitHub issue
   - The title should be the line item text
   - The first comment should be the acceptance criteria (i.e., what you need to accomplish for it to be "complete")
   - Leave these in "to do" status until you start working on them
   - Assign each issue to your Project Board (the right-side panel)
   - Assign each issue to yourself (the right-side panel)
6. As you work
  1. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone branch as the source)
  2. Add, commit, push the related file changes to this branch
  3. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented
     - Screenshot(s) of the site view (make sure they clearly show the feature)
     - Screenshot of the database data if applicable
     - Describe each screenshot to specify exactly what's being shown
     - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
  4. Update the checklist of the proposal.md file for each feature this is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)
    - Basically add an x to the checkbox markdown along with a date after
      - (i.e.,   - [x] (mm/dd/yy) ....) See Template above
    - Add the pull request link as a new indented line for each line item being completed
    - Attach any related issue items on the right-side panel
  5. Merge the Feature Branch into your Milestone branch (this should close the pull request and the attached issues)
    - Merge the Milestone branch into dev, then dev into prod as needed
    - Last two steps are mostly for getting it to prod for delivery of the assignment 
  7. If the attached issues don't close wait until the next step
  8. Merge the updated dev branch into your production branch via a pull request
  9. Close any related issues that didn't auto close
    - You can edit the dropdown on the issue or drag/drop it to the proper column on the project board