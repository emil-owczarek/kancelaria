# Workflow Issue Investigation - FTP Deployment

## Problem Statement
The FTP deployment workflow ran only once and then stopped working.

## Root Cause
The workflow file (`.github/workflows/ftp-deploy.yml`) was accidentally removed from the main branch due to a merge conflict scenario:

1. **PR #1** added the FTP deployment workflow to main (commit `abdc5cd`)
2. The workflow ran once when this PR was merged
3. **PR #2** was created from the `test-actions` branch, which was based on commit `c058a8e` - *before* PR #1 was merged
4. When PR #2 was merged into main, it overwrote the branch history, effectively removing the workflow file that was added in PR #1

## Timeline
```
807bcb1 - Initial commit
  ├─ c058a8e → e581e1d → df8fe92 → 42024da → 7fe0fcf (test-actions branch)
  └─ d2f4868 → 4c619e9 → a9edc39 → 92dea96 (copilot/add-ftp-deployment-workflow)
                                        ↓
                                   abdc5cd (PR #1 merge - lost)
                                        ↓
                                   b6dec06 (PR #2 merge - overwrote main)
```

## Solution
Restored the `.github/workflows/ftp-deploy.yml` file from the `copilot/add-ftp-deployment-workflow` branch.

The workflow will now run on every push to the main branch as originally intended.

## Prevention
To prevent this in the future:
- Always ensure feature branches are rebased or merged with the latest main branch before creating a PR
- Use `git pull --rebase origin main` on feature branches to incorporate latest changes
- Review the files changed in a PR to ensure no unintended deletions
