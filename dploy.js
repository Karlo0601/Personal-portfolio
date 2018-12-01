'use strict';
const DPLOY = require("dploy");
const git = require('git-last-commit');
const MY_SLACK_WEBHOOK_URL = 'https://hooks.slack.com/services/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';
const slack = require('slack-notify')(MY_SLACK_WEBHOOK_URL);

// Set your project name here
const project_slug = 'am2-wordpress-theme';

const settings = {
  scheme: 'sftp',
  host: '45.79.133.165',
  user: 'myzonedev',
  pass: 'bb637e5f8ef97b9330abc77c660878b0',
  exclude: ["dploy.js", "dploy-live.js"], // So these files aren't deployed
  slots: 10,
  path: {
    local: '',
    remote: '/home/myzonedev/public_html/'+project_slug
  }
}

git.getLastCommit(function(err, commit) {  
  new DPLOY(settings, function() {
      slack.send({
        channel: '#'+project_slug, // Slack channel name
        text: `New changes: "${commit.subject}" is on staging site: https://myzonedev.com/${project_slug}`, // Staging url
        icon_url: 'http://am2studio.hr/logo-am2.png',
        username: 'Deployed by - '+commit.author.name,
      });
  });
});
