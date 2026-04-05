import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import '../../features/dashboard/presentation/provider_dashboard_screen.dart';

GoRouter providerRouter() {
  return GoRouter(
    routes: <RouteBase>[
      GoRoute(
        path: '/',
        builder: (BuildContext context, GoRouterState state) => const ProviderDashboardScreen(),
      ),
    ],
  );
}
