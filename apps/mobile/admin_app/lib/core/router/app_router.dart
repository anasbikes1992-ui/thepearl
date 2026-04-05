import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import '../../features/overview/presentation/admin_overview_screen.dart';

GoRouter adminRouter() {
  return GoRouter(
    routes: <RouteBase>[
      GoRoute(
        path: '/',
        builder: (BuildContext context, GoRouterState state) => const AdminOverviewScreen(),
      ),
    ],
  );
}
