FUTURE PROJECT GUIDELINES — safarimeet

Purpose
- Senior-architect guidance for planning new projects or major features to avoid repeating current mistakes.

1) Design before coding
- Draw simple sequence diagrams for the top 3 critical flows (booking, package creation, enquiry handling).
- Identify where validation, orchestration, and persistence belong before creating files.

2) Choose boundaries early
- Decide which models will be read-only for UIs and which require transactional writes.
- Decide on service names (BookingService, PackageService) and put skeletons early even if empty.

3) Prefer vertical slices for features
- Implement feature by feature: create request → DTO → service → repository → Livewire UI.
- Each slice should be test-covered and deployable.

4) Keep infra behind interfaces
- Define `ImageUploaderInterface`, `StorageInterface`, `NotificationSenderInterface` early so concrete infra can be swapped.

5) Default to composition, not inheritance
- Prefer small services and handlers composed inside a higher-level service rather than big class hierarchies.

6) Make presentation explicit
- Use Resource/Presenter classes to shape API and Livewire payloads so presentation logic is centralized.

7) Enforce via PR checks
- Add code review checklist: no DB writes in Livewire, no raw SQL in controllers, tests for new services.

8) Documentation and onboarding
- Keep `docs/` updated with architecture decisions for each major release so new developers follow the pattern.

9) Avoid premature optimization
- First aim for clear separation of concerns. Optimize queries inside repositories once usage patterns are known.

10) Iterate and simplify
- After initial implementation, revisit services for commonality and extract shared code only when duplication is real.

End of future guidelines.
